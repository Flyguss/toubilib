<?php

namespace toubilib\core\domain\entities\praticien;


class Praticien
{
    private string $id , $nom , $prenom , $ville , $email , $telephone , $structureID , $rppsID , $titre;
    private int  $specialiteID , $organisation , $nouveauPatient ;

    public function __construct ($id ,$n , $p , $v , $e ,$t , $s , $st , $r , $o , $np , $ti) {
        $this->id = $id ;
        $this->nom = $n ;
        $this->prenom = $p ;
        $this->ville = $v ;
        $this->email = $e ;
        $this->telephone = $t ;
        $this->specialiteID = (int) $s ;
        $this->structureID = $st ;
        if ($r == null) {
            $r = 'null' ;
        }
        $this->rppsID = $r ;
        $this->organisation = (int) $o ;
        $this->nouveauPatient = (int) $np ;
        $this->titre = $ti ;
    }

    public function getNom() {
        return $this->nom ;
    }
 

}