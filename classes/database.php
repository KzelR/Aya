<?php
class database
{
    function opencon()
    {
        return new PDO('mysql:host=localhost;dbname=ayadatabase1','root','');
    }
    function check($username,$password){
        $con = $this->opencon();
        $query = "SELECT * from admin WHERE user='".$username. "'&&pass='".$password."'";
        return $con->query($query)->fetch();
    }
    
    
    function signupUser($firstname, $lastname, $username, $password)
    {
        $con = $this->opencon();
        // Save user data along with profile picture path to the database
        $con->prepare("INSERT INTO admin (firstname,lastname, user, pass) VALUES (?,?,?,?)")->execute([$firstname, $lastname, $username, $password]);
        return $con->lastInsertId();
        }

    function view() {
            $con = $this->opencon();
    return $con->query("SELECT admin.admin_id, admin.firstname, admin.lastname, admin.user from admin")->fetchAll();
}

function delete($admin_id) {
try{
    $con = $this->opencon();
        $con->beginTransaction();

        $query2 = $con->prepare("DELETE FROM admin WHERE admin_id = ?");
        $query2->execute([$admin_id]);

        $con->commit();
        return true;
} catch (PDOException $e){
    $con->rollBack();
    return false;
}
}
function viewdata($admin_id){
try{
    $con = $this->opencon();
        $query = $con->prepare("SELECT admin.admin_id,admin.firstname, admin.lastname, admin.user WHERE admin.admin_id = ?");
        $query->execute([$admin_id]);
        return $query->fetch();
    }catch(PDOException $e){
    return [];
        }
    }
}