<?php
namespace rooms;
use base\room as room;
use base\salida as salida;
class login extends room{
  public $title="Portal Misterioso";
  public $description="description.html";
  protected $_urlPath="/access/login";
  public $exits=array(
    "letrero"=>array(
        "status"=>salida::EXIT_LOCKED,
        "name"=>"letrero",
        "title"=>"Mirar Letrero",
        "description"=>"ADVERTENCIA. Bienvenido a fantasía",
        "errorMSG"=>"<p>ADVERTENCIA. Bienvenido a fantasía, el lugar donde todo sueño es posible</p><p>Este es un sitio maravilloso lleno de cosas hermosas y secretos que te deslumbrarán. Pero no te engañes, pues fantasía es también el lugar más peligroso de todos.</p><p>Si posees una runa encantada úsala para entrar. De lo contrario puedes tomar una runa inactiva del montón que encontrarás junto a la puerta.</p>",
        "link"=>"\\rooms\\login",
        "alias"=>array("Mirar Letrero")
        ),
      "montonrunas"=>array(
              "status"=>salida::EXIT_LOCKED,
              "name"=>"montonrunas",
              "title"=>"Mirar Montón de rocas",
              "description"=>"ADVERTENCIA. Bienvenido a fantasía",
              "errorMSG"=>"<p>Aquí hay un montón de rocas. Cada roca es del tamaño de una nuez y tienen una extraña marca por encima.</p>",
              "link"=>"\\rooms\\login",
              "actions"=>array(
                  "dar"=>array("rooms\\objetos\\runa")
                )
              ),
      "tomar_runa"=>array(
                    "status"=>salida::EXIT_LOCKED,
                    "name"=>"tomar_runa",
                    "title"=>"Tomar una roca",
                    "description"=>"ADVERTENCIA. Bienvenido a fantasía",
                    "errorMSG"=>"<p>Acercas tu mano pero antes de tomar alguna roca sientes un terrible calambre que recorre todo tu brazo.</p><p>Una voz en tu cabeza dice: 'Tú ya tienes una runa de acceso'</p>",
                    "link"=>"\\rooms\\login",
                    "keys"=>array(
                        "tiene_runa"=>array(
                          "condiciones"=>array(
                            salida::KEY_CONDICION_NOTIENEOBJETO=>"\\rooms\\objetos\\runa"
                          ),
                          "acciones"=>array(
                            "crearRuna"=>array(
                                "accion"=>salida::ACCION_CREAROBJETO,
                                "clase"=>"\\rooms\\objetos\\runa",
                                "recoger"=>"true",
                                "sucessMessage"=>"<p>Has tomado una roca del montón</p>"
                            )
                          )
                        )
                      ),
                    "actions"=>array(
                        "dar"=>array("rooms\\objetos\\runa")
                      )
                    ),
      );
}
