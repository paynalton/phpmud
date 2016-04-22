<?php
namespace rooms\objetos;
use base\room as room;
use base\salida as salida;

class runa extends room{
  const TEMPERATURA_FRIO=1;
  const TEMPERATURA_TIBIO=2;
  const TEMPERATURA_CALIENTE=3;

  const COLORACION_PALIDO=1;
  const COLORACION_OSCURO=2;
  const COLORACION_ROJO=3;
  const COLORACION_VERDE=4;
  const COLORACION_NEGRO=5;

  const EDAD_NUEVA=1;
  const EDAD_DESGASTADA=2;
  const EDAD_VIEJA=3;

  const TAMANYO_SMALL=1;
  const TAMANYO_MEDIUM=2;
  const TAMANYO_BIG=3;

  public $title="Runa Misteriosa";
  public $description="Parece una roca común y corriente";

  protected $propiedades_random=array(
    "TEMPERATURA"=>3,
    "COLORACION"=>5,
    "EDAD"=>3,
    "TAMANYO"=>3
  );

  protected $propiedades=array(
    "SUCIEDAD"=>array(0,10,5)
  );



  public $exits=array(
    "frotar"=>array(
        "status"=>salida::EXIT_LOCKED,
        "name"=>"frotar",
        "title"=>"Frotar",
        "description"=>"",
        "errorMSG"=>"<p>Le has quitado un poco de polvo de encima.</p>",
        "link"=>"\\rooms\\objetos\\runa",
        "alias"=>array("Frotar roca")
        ),
      );
  public function onLocked(salida $salida){
    switch($salida->name){
      case "frotar":
        $this->setPropiedad("SUCIEDAD",$this->SUCIEDAD-1);
      break;
    }
    return "";
  }
  public function description(){
    $descripcion="<p>Parece una roca común y corriente, pero sientes algo peculiar en ella</p>"
                ."<p>Es %s, luce %s. Es de un color %s. Al tacto se siente %s.</p>"
                ."<p>En su superficie se notan marcas en un lenguaje que no conoces.</p>";

    switch($this->TEMPERATURA){
      case self::TEMPERATURA_FRIO:
        $temperatura="fría, más de lo común en una roca";
      break;
      case self::TEMPERATURA_TIBIO:
        $temperatura="tibia, cual si la roca misma fuese un ser viviente";
      break;
      case self::TEMPERATURA_CALIENTE:
        $temperatura="ćálida, no mucho, pero lo suficiente como para notarlo";
      break;
    }
    switch($this->COLORACION){
      case self::COLORACION_PALIDO:
        $color="pálido, casi del color del mármol";
      break;
      case self::COLORACION_OSCURO:
        $color="oscuro, cual si fuese de madera o... una piel morena";
      break;
      case self::COLORACION_ROJO:
        $color="rojizo, te hace recordar el tono del atardecer";
      break;
      case self::COLORACION_VERDE:
        $color="turquesa, ese tono hermoso que solo tienen las piedras preciosas";
      break;
      case self::COLORACION_NEGRO:
        $color="negro, es tan oscura que tu mirada se pierde en ella";
      break;
    }
    switch($this->EDAD){
      case self::EDAD_NUEVA:
        $edad="lisa y limpia, recien tallada";
      break;
      case self::EDAD_DESGASTADA:
        $edad="algo desgastada";
      break;
      case self::EDAD_VIEJA:
        $edad="muy vieja y desgastada, las marcas apenas se notan en su superficie";
      break;
    }
    switch($this->TAMANYO){
      case self::TAMANYO_SMALL:
        $tamanyo="pequeña, del tamaño de una nuez";
      break;
      case self::TAMANYO_MEDIUM:
        $tamanyo="mediana, del tamaño perfecto para sostenerla con tu mano";
      break;
      case self::TAMANYO_BIG:
        $tamanyo="bastante grande, aunque más ligera de lo que aparenta";
      break;
    }
    $descripcion=sprintf($descripcion,$tamanyo,$edad,$color,$temperatura);
    return $descripcion;
  }

}
