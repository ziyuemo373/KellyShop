<?php

namespace App\Http;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Arr;

class Tree {

	public $items = [];

	public $roles = [];

	public $current;

	public $currentKey;

	public function __construct() {
		$this->current = Request::url();
	}

	public static function create($callback = null) {
		$tree = new Tree();

		if ($callback) {
			$callback($tree);
		}

		return $tree;
	}

	public function add($item, $type = '')
	{
        $item['children'] = [];

		if ($type == 'menu') {
			$item['url'] = route($item['route']);

			if (strpos($this->current, $item['url']) !== false) {
				$this->currentKey = $item['key'];
			}
		} else if ($type == 'acl') {
			$item['name'] = trans($item['name']);
			$this->roles[$item['route']] = $item['key'];
		}

		$children = str_replace('.', '.children.', $item['key']);

        Arr::set($this->items, $children, $item);
	}

	public function getActive($item)
	{
		$url = trim($item['url'], '/');

		if ((strpos($this->current, $url) !== false) || (strpos($this->currentKey, $item['key']) === 0)) {
			return 'active';
		}
	}

    public function sortItems($items) {
        foreach ($items as &$item) {
            if (count($item['children'])) {
                $item['children'] = $this->sortItems($item['children']);
            }
        }

        usort($this->items, function($a, $b) {
            if ($a['sort'] == $b['sort']) {
                return 0;
            }

            return ($a['sort'] < $b['sort']) ? -1 : 1;
        });

        return $this->convertToAssociativeArray($items);
    }

    public function convertToAssociativeArray($items)
    {
        foreach ($items as $key1 => $level1) {
            unset($items[$key1]);
            $items[$level1['key']] = $level1;

            if (count($level1['children'])) {
                foreach ($level1['children'] as $key2 => $level2) {
                    $temp2 = explode('.', $level2['key']);
                    $finalKey2 = end($temp2);
                    unset($items[$level1['key']]['children'][$key2]);
                    $items[$level1['key']]['children'][$finalKey2] = $level2;

                    if (count($level2['children'])) {
                        foreach ($level2['children'] as $key3 => $level3) {
                            $temp3 = explode('.', $level3['key']);
                            $finalKey3 = end($temp3);
                            unset($items[$level1['key']]['children'][$finalKey2]['children'][$key3]);
                            $items[$level1['key']]['children'][$finalKey2]['children'][$finalKey3] = $level3;
                        }
                    }

                }
            }
        }

        return $items;
    }
}