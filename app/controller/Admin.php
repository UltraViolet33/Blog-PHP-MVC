<?php

require_once('../app/core/Controller.php');

class Admin extends Controller
{

    private $postController;

    public function __construct()
    {
        $this->checkAdminLogin();
        $this->postController  = $this->loadController("post");
        $this->categoryController = $this->loadController("category");
    }

    public function index()
    {
        $this->posts();
    }

    /**
     * display posts
     */
    public function posts($method = null, $id = null)
    {
        if ($method == "delete") {
            if ($_POST['token'] == $_SESSION['token']) {
                $this->deletePost($id);
                header("Location: " . ROOT . "admin/posts");
            } else {
                header("Location: " . ROOT . "login");
                return;
            }
        } elseif ($method == "update") {
            $this->updatePost($id);
            return;
        }

        $posts = $this->postController->getPaginatedPosts("admin/posts");
        $this->view("admin/posts", $posts);
    }

    /**
     * delete one post
     */
    public function deletePost($id)
    {
        $this->postController->delete($id);
    }

    /**
     * Update one post
     */
    public function updatePost($idPost)
    {
        if (!empty($_POST)) {
            if (empty($_POST['name']) || empty($_POST['content'])) {
                $_SESSION['error'] = "Veuillez renseigner les informations <br>";
            } else {
                $this->postController->update($idPost, $_POST['name'], $_POST['content']);
                header("Location: " . ROOT . "admin/posts");
            }
        }
        $post = $this->postController->postModel->find($idPost);
        $data['post'] = $post[0];
        $this->view("admin/editPost", $data);
    }

    /**
     * display categories
     */
    public function categories($method = null, $id = null)
    {
        if ($method == "delete") {
            if ($_POST['token'] == $_SESSION['token']) {
                $this->deleteCategory($id);
                header("Location: " . ROOT . "admin/categories");
            } else {
                header("Location: " . ROOT . "login") .
                    die;
            }
        } elseif ($method == "update") {
            $this->updateCategory($id);
            return;
        } elseif ($method == "create") {
            $this->createCategory();
            return;
        }
        $categories = $this->categoryController->getPaginatedCategories("admin/categories");
        $this->view('admin/categories', $categories);
    }

    /**
     * create a category
     */
    private function createCategory()
    {
        if (!empty($_POST)) {
            if (empty($_POST['name'])) {
                $_SESSION['error'] = "Veuillez renseigner un nom pour la categorie <br>";
            } else {
                $this->categoryController->insert($_POST['name']);
                header("Location: " . ROOT . "admin/categories");
            }
        }
        $this->view("admin/addCategory");
    }

    /**
     * update one category
     */
    private function updateCategory($id)
    {
        if (!empty($_POST)) {
            if (empty($_POST['name'])) {
                $_SESSION['error'] = "Veuillez renseigner un nom pour la categorie <br>";
            } else {
                $this->categoryController->update($id, $_POST['name']);
                header("Location: " . ROOT . "admin/categories");
            }
        }
        $category = $this->categoryController->getOneCategory($id);
        $data['category'] = $category[0];
        $this->view("admin/editCategory", $data);
    }

    /**
     * delete one category
     */
    public function deleteCategory($id)
    {
        $this->categoryController->delete($id);
    }
}
