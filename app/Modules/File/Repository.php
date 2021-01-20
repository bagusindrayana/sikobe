<?php

namespace App\Modules\File;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

interface Repository
{
    /**
     * Return list items.
     *
     * @param  array   $params
     * @param  integer $page
     * @param  integer $limit
     * 
     * @return \Collection
     */
    public function search(Array $params = [], $page = 1, $limit = 10);

    /**
     * Find a item by params.
     *
     * @param  array $params
     * 
     * @return \App\Modules\File\Models\File
     * 
     * @throws \App\Modules\File\RecordNotFoundException
     */
    public function findBy(Array $params);

    /**
     * Find the item by it's ID.
     *
     * @param  integer $id
     * 
     * @return \App\Modules\File\Models\File
     * 
     * @throws \App\Modules\File\RecordNotFoundException
     */
    public function find($id);

    /**
     * Create a new item.
     *
     * @param  Array $data
     * 
     * @return \App\Modules\File\Models\File|null
     * @throws \RuntimeException
     */
    public function create(Array $data);

    /**
     * Return latest query total items.
     *
     * @return integer
     */
    public function getTotal();
}
