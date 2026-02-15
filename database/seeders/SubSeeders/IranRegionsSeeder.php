<?php

namespace Database\Seeders\SubSeeders;

use App\Enums\SettlementTypeEnum;
use App\Enums\VillageTypeEnum;
use App\Models\IranRegion\County;
use App\Models\IranRegion\District;
use App\Models\IranRegion\Province;
use App\Models\IranRegion\Settlement;
use App\Models\IranRegion\Village;
use DB;
use Exception;
use Illuminate\Database\Seeder;

class IranRegionsSeeder extends Seeder
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        $this->handleImportingRecords(
            path: database_path('seeders/SubSeeders/IranRegionsData/ostan.csv'),
            modelClassName: Province::class,
        );

        $this->handleImportingRecords(
            path: database_path('seeders/SubSeeders/IranRegionsData/shahrestan.csv'),
            modelClassName: County::class,
            mappingFunction: function (array &$model, array $csvRecord) {
                $model['province_id'] = $csvRecord['ostan'];
            },
        );

        $this->handleImportingRecords(
            path: database_path('seeders/SubSeeders/IranRegionsData/bakhsh.csv'),
            modelClassName: District::class,
            mappingFunction: function (array &$model, array $csvRecord) {
                $model['county_id'] = $csvRecord['shahrestan'];
            },
        );

        $this->handleImportingRecords(
            path: database_path('seeders/SubSeeders/IranRegionsData/shahr.csv'),
            modelClassName: Settlement::class,
            mappingFunction: function (array &$model, array $csvRecord) {
                $model['district_id'] = $csvRecord['bakhsh'];
                if ($csvRecord['shahr_type'] == 2) {
                    $model['type'] = SettlementTypeEnum::URBAN_AREA->value;
                }
                else {
                    $model['type'] = SettlementTypeEnum::CITY->value;
                }
            },
            postMappingFunction: function (array &$records) {
                $maxId = max(array_column($records, 'id'));
                foreach ($records as $key => $record) {
                    if ($record['type'] == SettlementTypeEnum::CITY->value) {
                        $records[$key]['parent_id'] = null;
                    } else {
                        $parentName = trim(str_replace([0,1,2,3,4,5,6,7,8,9, ' ', '-'], '', $record['name']));

                        $result = array_values(array_filter($records, function ($record) use ($parentName) {
                            return trim(str_replace([' ', '-'], '', $record['name'])) == $parentName;
                        }));

                        if (isset($result[0])) {
                            $parent = $result[0];
                            $records[$key]['parent_id'] = $parent['id'];
                        } else {
                            $parent = [
                                'id' => ++$maxId,
                                'name' => trim(str_replace([0,1,2,3,4,5,6,7,8,9], '', $record['name'])),
                                'statistical_code' => null,
                                'type' => SettlementTypeEnum::CITY->value,
                                'parent_id' => null,
                                'district_id' => $record['district_id'],
                            ];
                            $records[$key]['parent_id'] = $parent['id'];
                            $records[] = $parent;
                        }
                    }
                }
                $this->orderByParents($records);
            },
            hasParents: true,
        );

        $shahrCsvRecordsMaxId = Settlement::max('id');

        $this->handleImportingRecords(
            path: database_path('seeders/SubSeeders/IranRegionsData/dehestan.csv'),
            modelClassName: Settlement::class,
            mappingFunction: function (array &$model, array $csvRecord) use ($shahrCsvRecordsMaxId) {
                $model['district_id'] = $csvRecord['bakhsh'];
                $model['type'] = SettlementTypeEnum::RURAL_DISTRICT->value;
                $model['id'] = $csvRecord['id'] + $shahrCsvRecordsMaxId;
            },
        );

        $this->handleImportingRecords(
            path: database_path('seeders/SubSeeders/IranRegionsData/abadi.csv'),
            modelClassName: Village::class,
            mappingFunction: function (array &$model, array $csvRecord) use ($shahrCsvRecordsMaxId) {
                $model['settlement_id'] = $csvRecord['dehestan'] + $shahrCsvRecordsMaxId;

                if ($csvRecord['abadi_type'] == 1 && $csvRecord['diag'] != null) {
                    $model['type'] = VillageTypeEnum::BLOCKED_VILLAGE->value;
                }
                else {
                    $model['type'] = VillageTypeEnum::VILLAGE->value;
                }
            },
        );
    }

    private function orderByParents(array &$records): void
    {
        $parents = [];
        $children = [];

        foreach ($records as $record) {
            if (empty($record['parent_id'])) {
                $parents[] = $record;
            } else {
                $children[] = $record;
            }
        }

        $records = array_merge($parents, $children);
    }

    private function insertByChunk(array $records, int $chunkSize, string $tableName): void
    {
        foreach (array_chunk($records, $chunkSize) as $chunk) {
            DB::table($tableName)->insert($chunk);
        }
    }

    private function handleImportingRecords(
        string $path,
        string $modelClassName,
        callable $mappingFunction = null,
        callable $postMappingFunction = null,
        bool $hasParents = false
    ): void
    {
        $file = fopen($path, 'r');

        $headers = fgetcsv($file);

        $records = [];

        while ($line = fgetcsv($file)) {
            $modelArray = [];

            $record = array_combine($headers, $line);

            $modelArray['id'] = $record['id'];
            $modelArray['name'] = $record['name'];
            $modelArray['statistical_code'] = $record['amar_code'];

            if ($mappingFunction)
                $mappingFunction($modelArray, $record);

            foreach ($modelArray as $key => $value) {
                if (is_string($value)) {
                    $value = trim($value);
                    $modelArray[$key] = $value === '' ? null : $value;
                }
            }

            $records[] = $modelArray;
        }
        fclose($file);

        $tableName = (new $modelClassName)->getTable();

        if ($postMappingFunction) {
            $postMappingFunction($records);
        }

        $chunkSize = 1000;

        if ($hasParents) {
            // parents
            $this->insertByChunk(
                records: array_filter($records, fn ($record) => empty($record['parent_id'])),
                chunkSize: $chunkSize,
                tableName: $tableName,
            );
            // children
            $this->insertByChunk(
                records: array_filter($records, fn ($record) => !empty($record['parent_id'])),
                chunkSize: $chunkSize,
                tableName: $tableName,
            );
        } else {
            $this->insertByChunk(
                records: $records,
                chunkSize: $chunkSize,
                tableName: $tableName,
            );
        }

        $maxID = DB::table($tableName)->max('id');
        DB::statement("ALTER TABLE $tableName AUTO_INCREMENT = " . ($maxID + 1));
    }
}
