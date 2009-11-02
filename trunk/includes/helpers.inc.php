<?php

function html($text)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function htmlout($text)
{
    echo html($text);
}

class NikHelper {
    var $name = "";
    
    function __construct()
    {
        $this->name = "NikHelper";
    }
    
    function generate_nik($kodeProp = null, $kodeKab = null, $kodeKec, $dob, $laki=true, $nomorUrut) {
        if(!$kodeProp)
                $kodeProp = 36; // jatim
        if(!$kodeKab)
                $kodeKab = 40; // surabaya
                
        $date = '';
        $monthYear = '';		
        $monthYear = $this->output(strftime(date('my', $dob)));
        
        $y = $this->output(strftime(date('d', $dob)));
        $date = (int) $y;		
        if(!$laki) {
                $date = (int) $date;
                $date = $date + 40;			
        }			
        $date = sprintf('%02d', $date);
        $urutan = sprintf('%04d', $nomorUrut);			
        return $kodeProp.''.$kodeKab.''.$kodeKec.''.$date.''.$monthYear.''.$urutan; 
    }
}

function build_nik($kode_prop = null, $kode_kab = null, $kode_kec, $tanggal_lahir, $laki = true, $nomor_urut)
{
    $nik = new NikHelper();
    return $nik->generate_nik($kode_prop, $kode_kab, $kode_kec, $tanggal_lahir, $laki, $nomor_urut);
}

/*
 * check apakah semua field yang ada telah di isi ?
 * @return true jika semua field sudah di isi
 *         false jika ada field yang blm di isi
 */ 
function filled_out($form_vars)
{
    foreach($form_vars as $key => $value)
    {
        if(!isset($key) || $value == '')
        {
            return false;
        }
    }
    return true;
}

/*
 * check if existing group with kecamatan id already exist
 * or not
 */
function check_existing_groups($kecamatan_id)
{
    include "mysqli.inc.php";
    $sql= "select count(*) as count from access_groups where kecamatan_id = $kecamatan_id";
    $result = $mysqli_connection->query($sql);
    check_error($mysqli_connection);
    $row = $result->fetch_object();
    $mysqli_connection->close();
    return $row->count;
}

/*
 * check apakah user yang login sesuai dengan password yang dimasukkan
 * jika tidak sama dengan yang ada di table users maka
 * mengembalikan nilai 0 karena kombinasi user dan password yang dimasukan
 * tidak sesuai dengan yang ada di table
 * @return 0 jika tidak sama dengan table
 *         1 jika user dan password sesuai dengan data table.
 */         
function check_valid_user_password($user, $password)
{
    include('db.inc.php');
    
    $query = "select count(*) from users where username='$user' and password=password('$password')";

    $result = mysqli_query($link,  $query);
        //$mysqli->query($query);
    
    if(!$result)
    {
       $error = 'error fetchin users : '.mysqli_error($link);
       include('error.html.php');
       exit();
    }
    $found = 0;
    while($row = mysqli_fetch_array($result))
    {
      // processing row
      $found = (int) $row['count(*)'];
      
    }
    $result->free();
    mysqli_close($link);
    return $found;
}

/*
 * built select input
 * @param $name select input name
 * @param $values an array consist each element "key"=>"value"
 * @param $selected_index default select input selected index
 * @param $attributes additional attributes;
 */
function __select_input($name, $values, $selected_id = 1, $attributes= '')
{
    if(!is_array($values))
    {
        return "not array";
    }
    $result = "<select name='$name' $attributes >";
    foreach($values as $row)
    {
        $id = (int) $row['key'];        
        $option = "<option value='".$row['key']."'";
        if($id == $selected_id)
        {
            $option .= " selected='selected'";
        }
        $option .= ">".$row['value']."</option>";
        $result .= $option;
    }
    $result .= "</select>";
    return $result;
}

function __selected_index($array, $selected_item)
{
    $selected_index = 0;
    for($i = 0; i < sizeof($array); $i++)
    {
        if($array[$i] == $selected_enum)
        {
            $selected_index = $i;
            return $selected_index;
        }
    }
    return $selected_index;
}

function select_enum($table, $column, $selected_enum = '')
{
    include 'db.inc.php';
    $sql = "show columns from $table like '$column'";
    
    $result = mysqli_query($link, $sql);
    if(!$result)
    {
        $error = "error retrieving enum column $column from $table";
        include "error.html.php";
    }
    $row = mysqli_fetch_array($result);
    $str = str_replace("'","", substr($row[1],6,strlen($row[1])-7));
    $array = split(",", $str);
    mysqli_close($link);
    $selected_index = 0;
    if(sizeof($selected_enum) > 0)
    {
        $selected_index = __selected_index($array, $selected_enum);
    }
    return __select_input($column, $array, $selected_index);
}

function select_enum_without_default_value($table, $column, $attributes='')
{
    include "db.inc.php";
    $sql = "show columns from $table like '$column'";
    $result = mysqli_query($link, $sql);
    if(!$result)
    {
        $error = "error retrieving enum column '$column' from $table";
        include "error.html.php";
    }
    $row = mysqli_fetch_array($result);
    $str = str_replace("'","", substr($row[1], 6, strlen($row[1]) - 7));
    $array = split(",", $str);
    mysqli_close($link);
    
    $result = "<select name='$name' $attributes >";
    foreach($array as $item)
    {            
        $option = "<option value='".$item."'";       
        $option .= ">".$item."</option>";
        $result .= $option;
    }
    $result .= "</select>";
    return $result;
}

function select($table, $key, $value, $select_name, $where = "", $selected_key = 1)
{
    include 'db.inc.php';    
    $sql = "select $key, $value from $table";
    if(strlen($where) > 1)
    {
        $sql = "select $key, $value from $table where $where";
    }
    $result = mysqli_query($link, $sql);
    if(!$result)
    {
	$error = "error mengambil data $table(function helpers.inc.php -> select())";
	include 'error.html.php';
	exit();
    }
    $list = array();
    while($row = mysqli_fetch_array($result))
    {
	$list[] = array("key"=>$row[$key], "value"=>$row[$value]);
    }
    
    return __select_input($select_name, $list, $selected_key);
}

function Strip($value)
{
	if(get_magic_quotes_gpc() != 0)
  	{
    	if(is_array($value))  
			if ( array_is_associative($value) )
			{
				foreach( $value as $k=>$v)
					$tmp_val[$k] = stripslashes($v);
				$value = $tmp_val; 
			}				
			else  
				for($j = 0; $j < sizeof($value); $j++)
        			$value[$j] = stripslashes($value[$j]);
		else
			$value = stripslashes($value);
	}
	return $value;
}
function array_is_associative ($array)
{
    if ( is_array($array) && ! empty($array) )
    {
        for ( $iterator = count($array) - 1; $iterator; $iterator-- )
        {
            if ( ! array_key_exists($iterator, $array) ) { return true; }
        }
        return ! array_key_exists(0, $array);
    }
    return false;
}
?>
