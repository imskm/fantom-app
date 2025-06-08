<?php declare(strict_types=1);

namespace Application\Repositories;

use App\Models\Lead;
use Application\Traits\ModelOperationsTrait;

/**
 * LeadRepository
 */
class LeadRepository extends Lead
{
	protected static $_table = "leads";

	use ModelOperationsTrait;

    public static function make(array $data)
    {
        $lead = new static;

        self::populateLead($data, $lead);
        $lead->created_at = date("Y-m-d H:i:s");

        return $lead;
    }

    private static function populateLead(array $data, LeadRepository $lead)
    {
        $lead->first_name = trim($data['first_name']);
        $lead->phone = $data['phone'];
        $lead->last_name = isset($data['last_name']) ? trim($data['last_name']) : "";
        if (isset($data['email'])) {
            $lead->email = $data['email'];
        }
    }

	public static function stats()
    {
        $table = self::$_table;

        $sql = "
            SELECT COUNT(*) lead_count FROM $table
        ";

        $stats = static::raw($sql)->first();

        return $stats;
    }
}