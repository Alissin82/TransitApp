<?php

namespace App\Services;

use App\Models\Terminal;
use Illuminate\Pagination\LengthAwarePaginator;

class TerminalService
{
    /**
     * Get all terminals with pagination
     */
    public function paginate(int $perPage = 15, string $search = ''): LengthAwarePaginator
    {
        $query = Terminal::with([
            'province',
            'county',
            'district',
            'settlement',
            'village'
        ]);

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhereHas('province', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('county', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('district', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('settlement', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('village', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });
            });
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get terminal by ID
     */
    public function find(int $id): ?Terminal
    {
        return Terminal::with([
            'province',
            'county',
            'district',
            'settlement',
            'village'
        ])->find($id);
    }

    /**
     * Create a new terminal
     */
    public function create(array $data): Terminal
    {
        return Terminal::create($data);
    }

    /**
     * Update an existing terminal
     */
    public function update(Terminal $terminal, array $data): bool
    {
        return $terminal->update($data);
    }

    /**
     * Delete a terminal
     */
    public function delete(Terminal $terminal): bool
    {
        return $terminal->delete();
    }
}
