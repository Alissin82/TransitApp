<x-layouts.app-content>
    <x-common.page-breadcrumb :pageTitle="$transitLine ? model_trans('transit-line', 'edit') : model_trans('transit-line', 'create')" />

    <div class="flex flex-col gap-5">

        <x-tables.filters-panel class="grid! grid-cols-2!">
            <x-forms.select
                    name="province_id"
                    label="{{ __('Province') }}"
                    placeholder="{{ __('Select Province') }}"
                    :options="$provinces"
                    :selected="(bool) $province_id"
                    wire:model.live="province_id"
            />
            <x-forms.select
                    name="county_id"
                    label="{{ __('County') }}"
                    placeholder="{{ __('Select County') }}"
                    :options="$counties"
                    :selected="(bool) $county_id"
                    wire:model.live="county_id"
                    :disabled="!$province_id"
            />

            <x-forms.select
                    name="district_id"
                    label="{{ __('District') }}"
                    placeholder="{{ __('Select District') }}"
                    :options="$districts"
                    :selected="(bool) $district_id"
                    wire:model.live="district_id"
                    :disabled="!$county_id"
            />
            <x-forms.select
                    name="settlement_id"
                    label="{{ __('Settlement') }}"
                    placeholder="{{ __('Select Settlement') }}"
                    :options="$settlements"
                    :selected="(bool) $settlement_id"
                    wire:model.live="settlement_id"
                    :disabled="!$district_id"
            />

            <x-forms.select
                    name="village_id"
                    label="{{ __('Village') }}"
                    hint="{{ __('Optional') }}"
                    placeholder="{{ __('Select Village') }}"
                    :options="$villages"
                    wire:model.live="village_id"
                    :disabled="!$settlement_id"
            />

            <x-slot:footer>
                <x-ui.button variant="outline" wire:click="resetFilters">
                    <x-slot name="startIcon">
                        <i class="fa-solid fa-xmark"></i>
                    </x-slot>
                    {{ __('Reset filters') }}
                </x-ui.button>
            </x-slot:footer>
        </x-tables.filters-panel>

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
            {{-- Card Header --}}
            <div class="px-6 py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    {{ __('transit-line.singular') }}
                </h3>
            </div>
            {{-- Card Body --}}
            <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                <form wire:submit.prevent="save">
                    <div class="-mx-2.5 grid grid-cols-2 gap-x-3 gap-y-5">

                        <x-forms.select
                                name="origin_terminal_id"
                                label="{{ __('transit-line.fields.origin_terminal') }}"
                                placeholder="{{ __('Select(verb)') }}"
                                :options="$originTerminals"
                                :selected="(bool) $origin_terminal_id"
                                wire:model="origin_terminal_id"
                        />

                        <x-forms.select
                                name="destination_terminal_id"
                                label="{{ __('transit-line.fields.destination_terminal') }}"
                                placeholder="{{ __('Select(verb)') }}"
                                :options="$destinationTerminals"
                                :selected="(bool) $destination_terminal_id"
                                wire:model="destination_terminal_id"
                        />

                        <x-forms.text
                                name="estimated_distance_km"
                                label="{{ __('transit-line.fields.estimated_distance_km') }}"
                                wire:model="estimated_distance_km"
                                type="number"
                        />

                        <x-forms.text
                                name="estimated_duration_min"
                                label="{{ __('transit-line.fields.estimated_duration_min') }}"
                                wire:model="estimated_duration_min"
                                type="number"
                        />

                        <x-forms.text
                                name="base_price"
                                label="{{ __('transit-line.fields.base_price') }}"
                                wire:model="base_price"
                                type="number"
                        />

                        {{-- Actions --}}
                        <div class="col-span-full px-2.5">
                            <div class="mt-1 flex items-center gap-3 border-t border-gray-100 pt-6 dark:border-gray-800">

                                <x-ui.button type="submit">
                                    {{ $transitLine ? __('Save changes') : __('Save') }}
                                </x-ui.button>

                                <x-tables.button href="{{ route('transit-lines.index') }}" wire:navigate>
                                    {{ __('Cancel') }}
                                </x-tables.button>

                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app-content>
