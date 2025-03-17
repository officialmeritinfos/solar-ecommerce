<?php

namespace App\Enums;

enum TransactionStatus: int
{
    case PENDING = 0;
    case COMPLETED = 1;
    case FAILED = 2;
    case CANCELLED = 3;
    case REFUNDED = 4;
    case PROCESSING = 5;
    case REVERSED = 6;

    /**
     * Get human-readable label for each status.
     */
    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::COMPLETED => 'Completed',
            self::FAILED => 'Failed',
            self::CANCELLED => 'Cancelled',
            self::REFUNDED => 'Refunded',
            self::PROCESSING => 'Processing',
            self::REVERSED => 'Reversed',
        };
    }

    /**
     * Get badge color class (for UI purposes).
     */
    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::COMPLETED => 'success',
            self::FAILED => 'danger',
            self::CANCELLED => 'secondary',
            self::REFUNDED => 'info',
            self::PROCESSING => 'primary',
            self::REVERSED => 'dark',
        };
    }
}
