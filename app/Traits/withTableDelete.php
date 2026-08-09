<?php

namespace App\Traits;

use App\Exceptions\CannotDeleteException;
use Illuminate\Support\Str;

/**
 *
 * @property string $service
 * @property string $model
 *
 * Confirm → delete one / delete many, for any datatable component.
 *
 * Requires the consuming component to declare:
 *
 *     protected string $model   = Terminal::class;
 *     protected string $service = TerminalService::class;   // extends App\Class\Service
 *
 * ...plus withDatatable (hasSelection/selectedIds/resetSelection/resetPage)
 * and withToastNotification (toastSuccess/toastError) on the same component.
 *
 * The translation file key is derived from $model automatically
 * (Terminal::class → 'terminal'). Override translationResource() if a
 * model's lang file doesn't follow that convention.
 *
 * If a service needs to block a deletion (e.g. dependent records still
 * exist), it throws App\Exceptions\CannotDeleteException with an
 * already-translated message — caught here and shown as a toast, for
 * both single and bulk deletes.
 */
trait withTableDelete
{
    public ?int $pendingDeleteId = null;

    protected function translationResource(): string
    {
        return Str::snake(class_basename($this->model), '-');
    }

    public function confirmDelete(int $id): void
    {
        $this->pendingDeleteId = $id;
    }

    public function cancelDelete(): void
    {
        $this->pendingDeleteId = null;
    }

    public function executeDelete(): void
    {
        if ($this->pendingDeleteId === null) {
            return;
        }

        $modelClass = $this->model;

        if ($record = $modelClass::find($this->pendingDeleteId)) {
            try {
                app($this->service)->delete($record);
                $this->toastSuccess(model_trans($this->translationResource(), 'deleted'));
            } catch (CannotDeleteException $e) {
                $this->toastError($e->getMessage());
            }
        } else {
            $this->toastError(model_trans($this->translationResource(), 'not_found'));
        }

        $this->pendingDeleteId = null;
        $this->resetPage();
    }

    public function deleteSelected(): void
    {
        if (! $this->hasSelection()) {
            return;
        }

        $deleted = app($this->service)->deleteMany($this->selectedIds());

        if ($deleted > 0) {
            $this->toastSuccess(
                model_trans($this->translationResource(), 'deleted_many', ['count' => $deleted])
            );
        }

        $this->resetSelection();
        $this->resetPage();
    }
}
