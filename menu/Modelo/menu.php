<?php
    
    require_once(__DIR__.'/../../db.php');
    if(!isset($_SESSION)) { 
        session_start(); 
    } 

    class Menu extends Conexion{
        
        public function __construct(){
            $this->db = parent::__construct();
        }

        public function addPlatillo($nombre, $descripcion, $marca, $codigo, $existencia, $costo, $precio, $categoria, $imagen){
            $statement = $this->db->prepare("INSERT INTO product (name_product, description_product, mark_product, unitaryPrice_product, cost_product, code_product, productExistance, category_product, img_product) VALUES (:nombre, :descripcion, :marca, :precio, :costo, :codigo, :existencia, :categoria, :imagen)");
            $statement->bindParam(':nombre', $nombre);
            $statement->bindParam(':descripcion', $descripcion);
            $statement->bindParam(':marca', $marca);
            $statement->bindParam(':codigo', $codigo);
            $statement->bindParam(':existencia', $existencia);
            $statement->bindParam(':costo', $costo);
            $statement->bindParam(':precio', $precio);
            $statement->bindParam(':categoria', $categoria);
            $statement->bindParam(':imagen', $imagen);
            if ($statement->execute()) {
                header('Location: ../../menu.php');
            }else{
                header('Location: ../../menu.php');
            }
        }

        public function addUser($name,$lname,$email,$phone,$userType,$password){
            $statement = $this->db->prepare("INSERT INTO user (name_user, lname_user, phone_user, email_user, pass_user, id_userType) VALUES (:name, :lname, :phone, :email, :password, :userType)");
            $statement->bindParam(':name', $name);
            $statement->bindParam(':lname', $lname);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':phone', $phone);
            $statement->bindParam(':userType', $userType);
            $statement->bindParam(':password', $password);
            if ($statement->execute()) {
                header('Location: ../../createUser.php');
            }else{
                header('Location: ../Vista/add.php');
            }
        }

        public function addCategoria($nombrecategoria){
            $statement = $this->db->prepare("INSERT INTO product_category (category_name) VALUES (:nombrecategoria)");
            $statement->bindParam(':nombrecategoria', $nombrecategoria);
            if ($statement->execute()) {
                header('Location: ../../menu.php');
            }else{
                header('Location: ../../menu.php');
            }
        }

        public function login($email, $password){
            // $rows = null;
            $statement = $this->db->prepare("SELECT * FROM user WHERE email_user = :Email AND pass_user = :Password LIMIT 1");
            $statement->bindParam(':Email',$email);
            $statement->bindParam(':Password',$password);
            if ($statement->execute()) {
                $user = $statement->fetch();
                if($user!=null){
                    switch($user['userType']){
                        case 1:
                            header('Location:../../homeAdministrador.php');
                        break;
                        case 2:
                            header('Location:../../homeMesero.php');
                        break;
                        case 3:
                            header('Location:../../homeContador.php');
                        break;
                    }
                }else{
                    echo "No existe ese usuario con esa contraseña";
                }
               
            }else{
                header('Location: ../../index.php');
            }
            
        }

        public function get(){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM product");
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function getPlatillo($id){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM product WHERE id_product = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function setPlatillo($id, $nombre, $descripcion, $marca, $codigo, $existencia, $costo, $precio, $categoria, $imagen){
            $rows = null;
            $statement = $this->db->prepare("UPDATE product SET name_product=:nombre, description_product=:descripcion, mark_product=:marca, code_product=:codigo, productExistance=:existencia, cost_product=:costo, unitaryPrice_product=:precio, category_product=:categoria, img_product=:imagen WHERE id_product = :idproduct");
            $statement->bindParam(':idproduct', $id);
            $statement->bindParam(':nombre', $nombre);
            $statement->bindParam(':descripcion', $descripcion);
            $statement->bindParam(':marca', $marca);
            $statement->bindParam(':codigo', $codigo);
            $statement->bindParam(':existencia', $existencia);
            $statement->bindParam(':costo', $costo);
            $statement->bindParam(':precio', $precio);
            $statement->bindParam(':categoria', $categoria);
            $statement->bindParam(':imagen', $imagen);
            if ($statement->execute()) {
                header('Location: ../../menu.php');
            }else{
                header('Location: ../../menu.php');
            }
        }

        public function setPlatilloSinImagen($id, $nombre, $descripcion, $marca, $codigo, $existencia, $costo, $precio, $categoria){
            $rows = null;
            $statement = $this->db->prepare("UPDATE product SET name_product=:nombre, description_product=:descripcion, mark_product=:marca, code_product=:codigo, productExistance=:existencia, cost_product=:costo, unitaryPrice_product=:precio, category_product=:categoria WHERE id_product = :idproduct");
            $statement->bindParam(':idproduct', $id);
            $statement->bindParam(':nombre', $nombre);
            $statement->bindParam(':descripcion', $descripcion);
            $statement->bindParam(':marca', $marca);
            $statement->bindParam(':codigo', $codigo);
            $statement->bindParam(':existencia', $existencia);
            $statement->bindParam(':costo', $costo);
            $statement->bindParam(':precio', $precio);
            $statement->bindParam(':categoria', $categoria);
            if ($statement->execute()) {
                header('Location: ../../menu.php');
            }else{
                header('Location: ../../menu.php');
            }
        }

        public function getCategorias(){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM product_category");
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function getCategoria($id){
            $rows = null;
            $statement = $this->db->prepare("SELECT category_name FROM product_category WHERE id_category = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        public function setCategoria($categoryname, $idcategory){
            $rows = null;
            $statement = $this->db->prepare("UPDATE product_category SET category_name = :categoryname WHERE id_category = :idcategory");
            $statement->bindParam(':categoryname', $categoryname);
            $statement->bindParam(':idcategory', $idcategory);
            if ($statement->execute()) {
                header('Location: ../../adminCategorias.php');
            }else{
                header('Location: ../../adminCategorias.php');
            }
        }

        public function getUserType(){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM userType");
            $statement->execute();
            while($result = $statement->fetch()){
                $rows[] = $result;
            }
            return $rows;
        }

        public function delete($Id){
            $statement = $this->db->prepare("DELETE FROM product WHERE id_product = :Id");
            $statement->bindParam(':Id',$Id);
            if ($statement->execute()) {
                header('Location: ../../menu.php');
            }else{
                header('Location: ../../menu.php');
            }
        }

        public function deleteCategoria($Id){
            $statement = $this->db->prepare("DELETE FROM product_category WHERE id_category = :Id");
            $statement->bindParam(':Id',$Id);
            if ($statement->execute()) {
                header('Location: ../../menu.php');
            }else{
                header('Location: ../../menu.php');
            }
        }

        public function getNombre(){
            return $_SESSION['NOMBRE'];
        }

        public function getId(){
            return $_SESSION['ID'];
        }

        public function getPerfil(){
            return $_SESSION['PERFIL'];
        }

        public function validateSession(){
            if ($_SESSION['ID'] == null) {
                header('Location: ../../index.php');
            }
        }

        public function salir(){
            $_SESSION['ID'] = null;
            $_SESSION['NOMBRE'] = null;
            $_SESSION['PERFIL'] = null;
            session_destroy();
            header('Location: ../../index.php');
        }

        public function getTabla($nombreTabla){
            $rows = null;
            $statement = $this->db->prepare("SELECT * FROM $nombreTabla");
            $statement->execute();
            while ($result = $statement->fetch()) {
                $rows[] = $result; 
            }
            return $rows;
        }

        
    }

?>