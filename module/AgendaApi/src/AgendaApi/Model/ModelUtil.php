<?php

namespace AgendaApi\Model;


class ModelUtil 
{
    
    /**
     * @param  array $data
     * @return null|IdModel|array
     */
    public static function findByIdInArray(array $data, int $id)
    {
        return array_reduce(
            $data,
            function ($result,  $item) use ($id) {
                if(is_object($item)){
                    return $item->id == $id ? $item : $result;
                }
                if(is_array($item)){
                    return $item['id'] == $id ? $item : $result;
                }
                return null;
                
            }
        );
    }
}
