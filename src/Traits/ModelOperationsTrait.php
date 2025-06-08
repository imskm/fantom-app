<?php

namespace Application\Traits;


/**
 * ModelOperationsTrait 
 */
trait ModelOperationsTrait
{
	public static function find($id)
	{
		if (!is_null(($model = parent::find($id)))) {
			$model = $model->first();
		}

		return $model;
	}

	public static function recent($page = 1, $items = 10, array $filter = [])
	{
		$bindings = [];
		$where_clause = "";
		$table = self::$_table;
		$offset = calc_page_offset($page, $items);
		$sort = isset($filter['sort'])? $filter['sort']['value'] : 'DESC';
		$i = 0;
		$sql = "
			SELECT *
			FROM $table
			%s
			ORDER BY id {$sort}
			LIMIT $items OFFSET $offset
		";

		// @TODO The way sort key is set in filter is not the correct way to do it.
		//   the other values of $filter are well defined but sort is out of the way
		//   find the clean way to do it.
		// Remove sort from array
		unset($filter['sort']);

		foreach ($filter as $key => $f) {
			if ($i === 0) {
				$where_clause = "WHERE {$table}.{$f['field']} {$f['op']} :{$key}";
				$bindings[$key] = $f['value'];
			} else {
				$where_clause .= " AND {$table}.{$f['field']} {$f['op']} :{$key}";
				$bindings[$key] = $f['value'];
			}

			++$i;
		}

		$sql = sprintf($sql, $where_clause);

		return static::raw($sql, $bindings);
	}

	public static function filter(array $filter, $page = 1, $items = 10)
	{
		$i = 0;
		$bindings = [];
		$where_clause = "";
		$table = self::$_table;
		$offset = calc_page_offset($page, $items);
		$sort = isset($filter['sort'])? $filter['sort']['value'] : 'DESC';
		$sort_on = "id";
		if (isset($filter['sort']) && isset($filter['sort']['field'])) {
			$sort_on = $filter['sort']['field'];
		}
		$sql = "
			SELECT *
			FROM $table
			%s
			ORDER BY {$sort_on} {$sort}
			LIMIT $items OFFSET $offset
		";
		// @TODO The way sort key is set in filter is not the correct way to do it.
		//   the other values of $filter are well defined but sort is out of the way
		//   find the clean way to do it.
		// Remove sort from array
		unset($filter['sort']);

		foreach ($filter as $key => $f) {
			if (!is_null($f['value']) && empty($f['value']) && !is_int($f['value'])) {
				continue;
			}
			if ($i === 0) {
				if ($key == 'search') {
					$fields = is_array($f['field']) ? $f['field'] : [$f['field']];
					$where_clause = "WHERE (".self::stringifyColumns($fields). ")";
					$bindings = array_merge($bindings, self::constructBindings($fields, $f['value']));
				} else if (is_null($f['value'])) {
					$where_clause = "WHERE {$f['field']} {$f['op']} NULL";
				} else {
					$where_clause = "WHERE {$f['field']} {$f['op']} :{$key}";
					$bindings[$key] = $f['value'];
				}
			} else {
				if ($key == 'search') {
					$fields = is_array($f['field']) ? $f['field'] : [$f['field']];
					$where_clause .= " AND (".self::stringifyColumns($fields). ")";
					$bindings = array_merge($bindings, self::constructBindings($fields, $f['value']));
				} else if (is_null($f['value'])) {
					$where_clause .= " AND {$f['field']} {$f['op']} NULL";
				} else {
					$where_clause .= " AND {$f['field']} {$f['op']} :{$key}";
					$bindings[$key] = $f['value'];
				}
			}

			++$i;
		}

		$sql = sprintf($sql, $where_clause);

		return static::raw($sql, $bindings);
	}

	public static function recentByUserId($user_id, $page = 1, $items = 10)
	{
		$table = self::$_table;
		$offset = calc_page_offset($page, $items);
		$sql = "
			SELECT *
			FROM $table
			WHERE user_id = :user_id
			ORDER BY id DESC
			LIMIT $items OFFSET $offset
		";

		return static::raw($sql, ['user_id' => $user_id]);
	}

	public function thisId()
	{
		return $this->lastId()? $this->lastId() : $this->id;
	}

	public static function searchBy($columns, $query, $page = 1, $items = 10)
	{
		$offset = calc_page_offset($page, $items);
		$table = self::$_table;
		$where_string = self::stringifyColumns($columns);
		$sql = "
			SELECT *
			FROM $table
			WHERE $where_string
			LIMIT $items OFFSET $offset
		";
		$bindings = self::constructBindings($columns, $query);

		return static::raw($sql, $bindings)->get();
	}

	private static function stringifyColumns($columns)
	{
		$columns_string = "";
		if (is_array($columns)) {
			$count = count($columns);
			for ($i = 0; $i < $count; ++$i) {
				$col = $columns[$i];
				if ($i === $count - 1) {
					$columns_string .= "{$col} LIKE :{$col}";
				} else {
					$columns_string .= "{$col} LIKE :{$col} OR ";
				}
			}
		} else if (is_string($columns)) {
			$columns_string = $columns;
		} else {
			throw new \Exception("Invalid argument '$columns'");
		}

		return $columns_string;
	}

	private static function constructBindings($params, $value)
	{
		$bindings = [];
		if (is_array($params)) {
			foreach ($params as $param) {
				$bindings[$param] = "%$value%";
			}
		} else if (is_string($params)) {
				$bindings[$params] = "%$value%";
		}

		return $bindings;
	}

	public static function generateSlug($string, $append_random_string = true)
	{
		$string = strtolower(trim($string));
		$slug = "";
		foreach (mb_str_split($string) as $ch) {
			if (ctype_alnum($ch)) {
				$slug .= $ch;
			} else if (ctype_space($ch)) {
				$slug .= "-";
			}
		}

		// Append random string to make slug unique
		if ($append_random_string) {
			$slug .= "-" . strtolower(gen_file_name(8));
		}

		return $slug;
	}

	public function fullName()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

	public static function findIn(array $ids, $page = 1, $limit = 15)
	{
		if (empty($ids)) {
			return null;
		}

		$offset = calc_page_offset($page, $limit);
		$table = self::$_table;
		$ids_str = implode(", ", $ids);
		$sql = "
			SELECT *
			FROM $table
			WHERE id IN ($ids_str)
			LIMIT $limit OFFSET $offset
		";

		return static::raw($sql);
	}

	public static function findBySlug($slug)
	{
		return static::where('slug', $slug)->first();
	}

	/**
	 *
	 * JOINS:
	 * [
	 *     ["table" => "table_2", "foreign" => "table_1_id", "primary" => "id"],
	 *     ["table" => "table_2", "foreign" => "table_1_id", "primary" => "id"],
	 *     ...
	 * ]
	 *
	 *
	 */
	public static function filterJoin(array $filter, array $joins = [], $page = 1, $items = 10)
	{
		$i = 0;
		$bindings = [];
		$where_clause = "";
		$table = self::$_table;
		$offset = calc_page_offset($page, $items);
		$sort = isset($filter['sort'])? $filter['sort']['value'] : 'DESC';
		$inner_join = "";
		$sql = "
			SELECT {$table}.*
			FROM $table
			%s
			%s
			ORDER BY id {$sort}
			LIMIT $items OFFSET $offset
		";
		// @TODO The way sort key is set in filter is not the correct way to do it.
		//   the other values of $filter are well defined but sort is out of the way
		//   find the clean way to do it.
		// Remove sort from array
		unset($filter['sort']);

		foreach ($filter as $key => $f) {
			if (!is_null($f['value']) && empty($f['value']) && !is_int($f['value'])) {
				continue;
			}
			$field = strchr($f['field'], ".") ? $f['field'] : "{$table}.{$f['field']}";
			if ($i === 0) {
				if (is_null($f['value'])) {
					$where_clause = "WHERE {$field} {$f['op']} NULL";
				} else {
					$where_clause = "WHERE {$field} {$f['op']} :{$key}";
					$bindings[$key] = $f['value'];
				}
			} else {
				if (is_null($f['value'])) {
					$where_clause .= " AND {$field} {$f['op']} NULL";
				} else {
					$where_clause .= " AND {$field} {$f['op']} :{$key}";
					$bindings[$key] = $f['value'];
				}
			}

			++$i;
		}

		foreach ($joins as $join) {
			// "INNER JOIN table2 ON table2.foreign_id = table1.id";
			$join = (object) $join;
			$part = " INNER JOIN {$join->table} ON {$join->table}.{$join->foreign} = {$table}.{$join->primary}";

			$inner_join .= $part;
		}

		$sql = sprintf($sql, $inner_join, $where_clause);

		return static::raw($sql, $bindings);
	}

	public static function calculatePagination(int $items_per_page)
    {
        $table = self::$_table;
        $sql = "
            SELECT COUNT(*) AS total FROM $table
        ";

        $result = static::raw($sql)->first();

        return (object) [
            'total'         => $result->total,
            'total_page'    => $last_page = ceil($result->total / $items_per_page),
            'current_page'  => get_page(),
            'last_page'     => $last_page,
        ];
    }
}