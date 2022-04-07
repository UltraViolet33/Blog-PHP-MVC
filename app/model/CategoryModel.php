<?php

require_once('../app/model/model.php');

class CategoryModel extends Model
{
    protected $table = "category";

    /**
     * insertCategories
     * to test the bdd ans the categories
     */
    public function insertCategories()
    {
        for ($i = 1; $i < 50; $i++) {
            $query = "INSERT INTO category(name, slug) VALUES('cat{$i}', 'cat-{$i}')";
            $this->db->write($query);
        }
    }


    public function insertPostCategory()
    {
        for($i=269; $i<320; $i++)
        {
            $categoryId = rand(4, 28);
            $query = "INSERT INTO post_category(post_id, category_id) VALUES($i, $categoryId)";
            $this->db->write($query);
        }
    }

   
}
