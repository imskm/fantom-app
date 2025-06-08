<?php declare(strict_types=1);

namespace Application\Repositories;

use App\Models\VisitorTracking;
use Application\Traits\ModelOperationsTrait;

/**
 * LeadRepository
 */
class VisitorTrackingRepository extends VisitorTracking
{
	protected static $_table = "visitor_tracking";

	use ModelOperationsTrait;

    public static function make(array $data)
    {
        $VisitorTracking = new static;
        $VisitorTracking->visitor_id    = $data['visitor_id'];
        $VisitorTracking->blog_post_id    = $data['blog_post_id'];

        $VisitorTracking->created_at = $VisitorTracking->updated_at = date("Y-m-d H:i:s");

        return $VisitorTracking;
    }

    public static function findByTokenAndBlogPostId($token, $blog_id)
    {
        return self::where('visitor_id', $token)
                    ->andWhere('blog_post_id', $blog_id);
    }

    

}