<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class GameFilters extends QueryFilters
{
    /**
     * Filter by search keyword.
     *
     * @param  string $genre
     * @return Builder
     */
    public function search($search = null)
    {
        if(empty($search)) {return $this->builder;}
        return $this->builder->where('title', 'like', ("%{$search}%"));
    }

    /**
     * Filter by score.
     *
     * @param  string $order
     * @return Builder
     */
    public function score($score = 0)
    {
        if($score > 0 && $score <= 100) {
            return $this->builder->where('score', '>=', $score);
        }

        return $this->builder;
    }

    /**
     * Filter by popularity, rating or recently added.
     *
     * @param  string $order
     * @return Builder
     */
    public function sort($order = 'popular')
    {
        if($order == 'popular') 
        {
            return $this->builder->orderByRaw('-popularity_rank desc');
        }
        else if($order == 'recent') 
        {
            return $this->builder->orderBy('created_at', 'desc');
        }
        else if($order == 'rating') 
        {
            return $this->builder->orderByRaw('-score_rank desc');
        }
        else { return $this->builder; }
    }

    /**
     * Filter by developers.
     *
     * @param  string $ids
     * @return Builder
     */
    public function developers($ids = '')
    {
        // Check if empty
        if(empty($ids)) {return $this->builder;}

        $ids = $this->stringIdsToArray($ids);

        return $this->builder->whereIn('developer_id', $ids);
    }

    /**
     * Filter by publishers.
     *
     * @param  string $ids
     * @return Builder
     */
    public function publishers($ids = '')
    {
        // Check if empty
        if(empty($ids)) {return $this->builder;}

        return $this->gameBuilder('releases AS r_alias', 'r_alias.game_id', 'r_alias.publisher_id', $ids);
    }

    /**
     * Filter by platforms.
     *
     * @param  string $ids
     * @return Builder
     */
    public function platforms($ids = '')
    {
        // Check if empty
        if(empty($ids)) {return $this->builder;}

        return $this->gameBuilder('releases AS p_alias', 'p_alias.game_id', 'p_alias.platform_id', $ids);
    }

    /**
     * Filter by genres.
     *
     * @param  string $ids
     * @return Builder
     */
    public function genres($ids = '')
    {
        // Check if empty
        if(empty($ids)) {return $this->builder;}
        
        return $this->gameBuilder('game_genre', 'game_genre.game_id', 'game_genre.genre_id', $ids);
    }


    /**
     * Create game builder query
     *
     * @param  string $joinTable
     * @param  string $joinColumn
     * @param  string $where
     * @param  string $ids
     * @return Builder
     */
    public function gameBuilder($joinTable, $joinColumn, $where, $ids) 
    {
        $ids = $this->stringIdsToArray($ids);

        return $this->builder
            ->select('games.id', 
                'games.title', 
                'games.synopsis', 
                'games.icon', 
                'games.developer_id', 
                'games.user_id', 
                'games.created_at', 
                'games.score', 
                'games.popularity_rank', 
                'games.score_rank')
            ->distinct('games.id')
            ->join($joinTable, 'games.id', '=', $joinColumn)
            ->whereIn($where, $ids);
    }

    /**
     * Convert string of ids to array
     *
     * @param  string $ids
     * @return Builder
     */
    public function stringIdsToArray($ids) 
    {
        $ids = str_replace(["[", "]"], ["", ""], $ids);

        //Ensure format is "n,n,n"
        $re = '/^\d+(?:,\d+)*$/';
        if(!preg_match($re, $ids)) {return $this->builder;}

        //Make an Array
        return explode(',', $ids);
    }
}