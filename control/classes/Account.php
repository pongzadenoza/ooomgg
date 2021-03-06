<?php

class Account
{

    private $id, $pass, $type, $email, $fname, $lname, $gender, $tel;

    public function __construct($id, $pass, $type, $email, $fname, $lname, $gender, $tel)
    {
        $this->id = $id;
        $this->pass = $pass;
        $this->type = $type;
        $this->email = $email;
        $this->fname = $fname;
        $this->lname = $lname;
        $this->gender = $gender;
        $this->tel = $tel;
    }

    public function getID()
    {
        return $this->id;
    }

    public function getPASS()
    {
        return $this->pass;
    }

    public function getTYPE()
    {
        return $this->type;
    }

    public function getEMAIL()
    {
        return $this->email;
    }

    public function getFNAME()
    {
        return $this->fname;
    }

    public function getLNAME()
    {
        return $this->lname;
    }

    public function getGENDER()
    {
        return $this->genger;
    }

    public function getTEL()
    {
        return $this->tel;
    }

    public function setID($id)
    {
        $this->id = id;
    }

    public function setPASS($pass)
    {
        $this->pass = pass;
    }

    public function setTYPE($type)
    {
        $this->TYPE = type;
    }

    public function setEMAIL($email)
    {
        $this->email = email;
    }

    public function setFNAME($fname)
    {
        $this->fname = fname;
    }

    public function setLNAME($lname)
    {
        $this->lname = lname;
    }

    public function setGENDER($gender)
    {
        $this->gender = gender;
    }

    public function setTEL($tel)
    {
        $this->tel = tel;
    }

    public static function loginAuth($acc_id, $acc_pass)
    {
        require 'config/config.php';
        $conn = new mysqli($hostname, $username, $password, $dbname);
        if ($acc_id != "" && $acc_pass != "") {
            $sql = "SELECT * FROM ACCOUNT WHERE ACC_ID = '" . $acc_id . "' AND ACC_PASS ='" . $acc_pass . "' ";
            $query = $conn->query($sql);
            $result = $query->fetch_assoc();
            if ($result) {
                $acc = new Account($result["ACC_ID"], $result["ACC_PASS"], $result["ACC_TYPE"], $result["ACC_EMAIL"], $result["ACC_FNAME"], $result["ACC_LNAME"], $result["ACC_GENDER"], $result["ACC_TEL"]);
                $conn->close();
                return $acc;
            }
        }
        $conn->close();
        return null;
    }

    public static function logout()
    {
        session_start();
        session_destroy();
        header("location:../index.php");
        exit();
    }

    public static function checkFavorite($cpro_id, $cacc_id)
    {
        require 'config/config.php';
        $pro_id = $cpro_id;
        $acc_id = $cacc_id;
        $conn = new mysqli($hostname, $username, $password, $dbname);
        $sql = "SELECT * FROM FAVORITE  WHERE PRO_INDEX ='" . $pro_id . "' AND ACC_ID ='" . $acc_id . "'  ";
        $query = $conn->query($sql);
        $result = $query->fetch_assoc();
        if ($result) {
            return TRUE;
        }
        return FALSE;
    }

    public static function registerAuth($accid)
    {
        require 'config/config.php';
        $conn = new mysqli($hostname, $username, $password, $dbname);
        $sql = "SELECT * FROM ACCOUNT WHERE ACC_ID='" . $accid . "' ";
        $query = $conn->query($sql);
        $result = $query->fetch_assoc();
        if ($result) {
            return false;
        }
        return true;
    }

    public static function createAcc($userinput, $passinput, $fname, $lname, $email, $phonenumber, $gender)
    {
        require 'config/config.php';
        $conn = new mysqli($hostname, $username, $password, $dbname);
        $sql = "INSERT INTO ACCOUNT (ACC_ID,ACC_PASS,ACC_FNAME,ACC_LNAME,ACC_EMAIL,ACC_TEL,ACC_GENDER)
            VALUES ('" . $userinput . "','" . $passinput . "','" . $fname . "','" . $lname . "','" . $email . "','" . $phonenumber . "','" . $gender . "')";
        $query = $conn->query($sql);
        return $query;
    }

    public static function getMyCart($account)
    {
        require 'config/config.php';
        $conn = new mysqli($hostname, $username, $password, $dbname);
        $sql = "SELECT * FROM CART WHERE ACC_ID = '" . $account->getID() . "' ";
        $query = $conn->query($sql);
        $conn->close();
        $resultArray = array();
        $count = 0;
        while ($result = $query->fetch_array()) {
            $temp = Product::ShowProductDetail($result['PRO_ID']);
            $temp->setPQuantity($result['QUANTITY']);
            $resultArray[] = $temp;
            $count ++;
        }
        if ($count === 0) {
            return NULL;
        }
        $cart = new Cart($result['CART_INDEX'], $resultArray);
        return $cart;
    }

    public static function addToMyCart($account, $pro_id, $quantity)
    {
        require 'config/config.php';
        $conn = new mysqli($hostname, $username, $password, $dbname);
        $sql = "SELECT * FROM CART WHERE ACC_ID = '" . $account->getID() . "' AND PRO_ID = '" . $pro_id . "';";
        $query = $conn->query($sql);
        $result = $query->fetch_assoc();
        if ($result) { // update
            $quantity += $result['QUANTITY'];
            $sql = "UPDATE CART SET QUANTITY = '" . $quantity . "' WHERE CART_INDEX = '" . $result['CART_INDEX'] . "';";
            $query = $conn->query($sql);
            $conn->close();
            return $query;
        } else { // new
            $sql = "INSERT INTO CART (ACC_ID,PRO_ID,QUANTITY)  VALUES ('" . $account->getID() . "','" . $pro_id . "'," . $quantity . ");";
            $query = $conn->query($sql);
            $conn->close();
            return $query;
        }
    }

    public static function removeFromMyCart($account, $pro_id)
    {
        require 'config/config.php';
        $conn = new mysqli($hostname, $username, $password, $dbname);
        $sql = "DELETE FROM CART WHERE ACC_ID = '" . $account->getID() . "' AND PRO_ID = '" . $pro_id . "';";
        $query = $conn->query($sql);
        $conn->close();
        if ($query) {
            return TRUE;
        }
        return FALSE;
    }
    public static function removeFavorite($acc_id,$pro_id)
    {
        require 'config/config.php';
        $conn = new mysqli($hostname, $username, $password, $dbname);
        $sql = "DELETE FROM FAVORITE WHERE ACC_ID='".$acc_id."' AND '".$pro_id."' ";
        $query = $conn->query($sql);
        echo "alert('delete wishlist')";
    }
    public static function addFavorite($acc_id,$pro_id)
    {
        require 'config/config.php';
        $conn = new mysqli($hostname, $username, $password, $dbname);
        $sql = "INSERT INTO FAVORITE (ACC_ID,PRO_INDEX) VALUES ('" . $acc_id . "','" . $pro_id . "')";
        $query = $conn->query($sql);
        echo "alert('wished')";
    }
}
?>
