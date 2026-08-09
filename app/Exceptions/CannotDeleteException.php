<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * Thrown by a service when a record cannot be deleted because of a
 * business rule (e.g. it still has dependent records).
 *
 * The message is expected to already be a translated, user-safe string —
 * WithBulkDelete shows it directly in a toast.
 */
class CannotDeleteException extends RuntimeException
{
}
