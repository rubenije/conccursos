<?php 
if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');	
	
	class parametro extends DB {
	    
		
		public function getParametroId($parametro_id){
			if(!empty($parametro_id) && is_numeric($parametro_id)){
				$sql 	= "SELECT * FROM parametro WHERE parametro_id = $parametro_id";
	        	return DB::getRow( $sql );
			}
			return false;		
	    }

	    public function getParametroByCodigo($para_codigo){
	        if(!empty($para_codigo) && is_string($para_codigo)){
            	$sql = "SELECT para_valor FROM parametro WHERE para_codigo = '$para_codigo' LIMIT 1";
            	return DB::getOne($sql);
        	}
	        return false;
	    }

	    public function saveParametro($data){
        	extract($data);
        	$parametro_id 	= (int) $parametro_id;
	        $para_orden 	= (int) $para_orden;
	        
	        $sql = "SELECT COUNT(*) FROM parametro WHERE parametro_id=$parametro_id";
	        if (DB::getOne($sql)) {
	            $sql = "UPDATE parametro SET para_nombre='$para_nombre', para_codigo='$para_codigo', para_valor='$para_valor', para_help='$para_help', para_estado='$para_estado', para_orden=$para_orden WHERE parametro_id=$parametro_id";
	        } else {
	            $sql = "INSERT INTO parametro (para_nombre, para_codigo, para_valor, para_help, para_estado, para_orden) VALUES ('$para_nombre', '$para_codigo', '$para_valor', '$para_help', '$para_estado',$para_orden)";
	        }
	        return DB::query($sql);
	    }


	    public function saveParametroAll($data){
        	foreach($data as $key => $value){
        		$parametro_id 	= (int) $key;
		        $para_valor 	= trim($value);
		        
		        $sql = "SELECT COUNT(*) FROM parametro WHERE parametro_id=$parametro_id";
		        if (DB::getOne($sql)) {
		            $sql = "UPDATE parametro SET para_valor='$para_valor' WHERE parametro_id=$parametro_id";
		        }
		        DB::query( $sql );
			}
	    }

	    public function saveParametroNewAll($data){
	    	if(is_array($data)){
	        	foreach($data as $key => $value){
	        		$para_codigo 	= trim($key);
			        $para_valor 	= trim($value);

			        if (strpos($para_codigo, '_IMAGEN') !== false) {
			        	$para_codigo 	= str_replace('_IMAGEN', '', $para_codigo);
			            $para_valor		= DB::uploadFileImage($para_codigo, $para_valor);
					}
					if (strpos($para_codigo, '_ARCHIVO') !== false) {
			        	$para_codigo 	= str_replace('_ARCHIVO', '', $para_codigo);
			            $para_valor		= DB::uploadFileArchivo($para_codigo, $para_valor);
					}
					
					if (strpos($para_codigo, '_TEXTAREA') !== false) {
			        	$para_codigo 	= str_replace('_TEXTAREA', '', $para_codigo);
			        	$para_valor		= $_REQUEST[$para_codigo.'_TEXTAREA'];
					}
					$sql = "SELECT COUNT(*) FROM parametro WHERE para_codigo= '$para_codigo'";
			        if (DB::getOne($sql)) {
			            $sql = "UPDATE parametro SET para_valor='$para_valor' WHERE para_codigo = '$para_codigo'";
			        }
			        DB::query( $sql );
			    }
			}
	    }

		public function getParametroAllGruped(){
	    	$sql = "SELECT para_grupo FROM parametro WHERE para_estado = 'A' GROUP BY para_grupo ORDER BY para_grupo ASC";
	    	return DB::getAll( $sql );
	    }


	    public function getParametroAllByGrupo($para_grupo){
	    	if(!empty($para_grupo) && is_string($para_grupo)){
	        	$sql = "SELECT * FROM parametro WHERE para_grupo = '$para_grupo' AND para_estado = 'A' ORDER BY para_orden ASC";
	            return DB::getAll( $sql);
		    }
		    return false;
	    }
	    
	    public function getParametroAll(){
    		$sql = "SELECT * FROM parametro ORDER BY para_orden ASC";
        	return DB::getAll( $sql );
    	}

	    public function getPublicParametroAll(){
    		$sql = "SELECT * FROM parametro WHERE para_estado = 'A' AND parametro_id = 13 ORDER BY para_nombre ASC";
        	return DB::getAll($sql);
    	
	    }


	    public function getInputHTML($object){
	    	if(!empty($object) && is_object($object)){
	    		switch ($object->para_tipo) {
					case "text":
						return parametro::getInputText($object);
						break;
					case "textarea":
						return parametro::getInputTextarea($object);
						break;
					case "imagen":
						return parametro::getInputFile($object);
						break;
					case "archivo":
						return parametro::getInputFile($object);
						break;
					case "option":
						return parametro::getInputOption($object);
						break;
					case "select":
						/*
						if (preg_match("/select/i", $this->params)) {
							return $this->select_sql($this->code, $this->value, $this->params, $this->help);					
						} else {
							return $this->select_options($this->code, $this->value, $this->params, $this->help);
						}
						*/
					case "select_especial":
						/*
						if (preg_match("/select/i", $params)) {
							list($sql, $nullValue) = explode(";", $params);
							return $this->select_sql($name, $valor, $sql, $help, $nullValue);					
						} else {
							return $this->select_options($name, $valor, $params, $help);
						}
						*/
					
				}


	    	}


	    }

	    public function getInputText($object){
	    	$html = '<input type="text" name="'.$object->para_codigo.'" class="form-control" value="'.$object->para_valor.'" required>';
	    	if($object->para_help){
	    		$html.= '<small class="help-block m-b-none">'.$object->para_help.'</small>';
	    	}
	    	return $html;
	    }


	    public function getInputTextarea($object){
	    	$html = '<textarea name="'.$object->para_codigo.'_TEXTAREA" rows="6" class="form-control" required>'.$object->para_valor.'</textarea>';
	    	if($object->para_help){
	    		$html.= '<small class="help-block m-b-none">'.$object->para_help.'</small>';
	    	}
	    	return $html;
	    }

	    public function getInputFile($object){
	    	$html = '<input type="hidden" name="'.$object->para_codigo.'_'.strtoupper($object->para_tipo).'" value="'.$object->para_valor.'">';
	    	$html.= '<div class="input-group input-file" name="'.$object->para_codigo.'">';
	    	$tipo = ($object->para_tipo == 'imagen') ? 'una Imagen' : 'un Archivo';
	    	$html.= '<input type="text" class="form-control" placeholder="Seleccione '.$tipo.'">';
	    	$html.= '<span class="input-group-btn">';
	    	$html.= '<button type="button" class="btn btn-primary btn-choose">Buscar</button>';
            $html.= '</span>';
            $html.= '</div>';

            if($object->para_help){
	    		$html.= '<small class="help-block m-b-none">'.$object->para_help.'</small>';
	    	}
	    	
            if(!empty($object->para_valor)){
            	if($object->para_tipo == 'imagen'){
	    			$html.= '<img src="../uploads/'.$object->para_valor.'"  class="img-rounded" style="width: 200px;">';
	    		}else{
	    			$html.= '<a href="../uploads/'.$object->para_valor.'" target="_blank">Documento</a>';
	    		}
	    	}
	    	return $html;
	    }

	    public function getInputOption($object){
	    	$html = '';
	    	$options 	= explode(';', $object->para_opcion);
	    	
	    	foreach ($options as $key => $option) {
	    		$explode 	= explode(':', $option);
	    		$value 		= $explode[0];
            	$text		= $explode[1];
            	$required 	= ($key == 0) ? 'required' : '';
	    		$checked	= ($value == $object->para_valor) ? 'checked' : '';
	    			
	    		$html.= '<div class="radio-inline"><label> <input type="radio" value="'.$value.'" name="'.$object->para_codigo.'" '.$checked.' '.$required.'> '.$text.' </label></div>';
	    	}
	    	return $html;
		}


		public function deleteParametroId($parametro_id){
			if(!empty($parametro_id) && is_numeric($parametro_id)){
				$delete = array('parametro_id' => $parametro_id);
	        	return DB::delete('parametro', $delete, 1 );
			}
			return false;
		}
		
	}
?>