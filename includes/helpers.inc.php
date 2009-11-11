<?php
include_once "mysqli.inc.php";
include_once "statics.id.inc.php";

date_default_timezone_set("Asia/Jakarta");

class NikHelper {
    var $name = "";
    
    function __construct()
    {
        $this->name = "NikHelper";
    }
    
    function generate_nik($kodeKec, $dob, $laki=true, $nomorUrut) {        
        $date = '';
        $monthYear = '';		        
        $monthYear = strftime(date('my', $dob));       
        
        $y = strftime(date('d', $dob));
        $date = (int) $y;		
        if(!$laki) {
                $date = (int) $date;
                $date = $date + 40;			
        }			
        $date = sprintf('%02d', $date);
        $urutan = sprintf('%04d', $nomorUrut);			
        return $kodeKec.''.$date.''.$monthYear.''.$urutan; 
    }
}

function build_nik($kode_kec, $tanggal_lahir, $laki = true, $nomor_urut)
{
    $nik = new NikHelper();
    return $nik->generate_nik($kode_kec, $tanggal_lahir, $laki, $nomor_urut);
}

function nik($kode_kec, $tanggal_lahir, $laki = true)
{
    $connection = MysqlManager::get_connection();
    // check kode_wilayah
    $sql = "select kd_wilayah from kecamatan where id = $kode_kec";
    $result = $connection->query($sql);
    check_error($connection);
    $row = $result->fetch_object();
    $kode_wilayah = $row->kd_wilayah;
       
    // check counter
    $sql = "select count(*) as count from nikcounter where kecamatan_id = $kode_kec and tanggal = '$tanggal_lahir'";
    $result = $connection->query($sql);
    check_error($connection);
    $row = $result->fetch_object();
    $count = $row->count;
    
    if($count == 0){// create new 
        $sql = "insert into nikcounter set kecamatan_id = $kode_kec, tanggal = '$tanggal_lahir', counter = 1";
        $connection->query($sql);
        check_error($connection);
        $connection->close();
        
        return build_nik($kode_wilayah, strtotime($tanggal_lahir), $laki, 1);
    } else {
        $sql = "select id, counter from nikcounter where kecamatan_id = $kode_kec and tanggal = '$tanggal_lahir'";
        $result = $connection->query($sql);
        check_error($connection);
        $row = $result->fetch_object();
        $count =$row->counter;
        $id = $row->id;
        $count = $count + 1;
        $sql = "update nikcounter set counter = $count where id = $id ";
        $connection->query($sql);
        check_error($connection);
        $connection->close();
        return build_nik($kode_wilayah,  strtotime($tanggal_lahir), $laki, $count);
    }
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


function check_error($connection)
{
   if(mysqli_errno($connection))
   {
      $error = "error query :".mysqli_error($connection);
      require_once "error.html.php";
      exit();
   }
}

/*
 * check if existing group with kecamatan id already exist
 * or not
 */
function check_existing_groups($kecamatan_id)
{
    $connection = MysqlManager::get_connection();
    $sql= "select count(*) as count from access_groups where kecamatan_id = $kecamatan_id";
    $result = $connection->query($sql);
    check_error($connection);
    $row = $result->fetch_object();
    MysqlManager::close_connection($connection);
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
    $conn = MysqlManager::get_connection();
    
    $query = "select count(*) as count from users where username='$user' and password=password('$password')";
    
    $result = $conn->query($query);
    check_error($conn);
    $row = $result->fetch_object();
    $found = $row->count;
    
    MysqlManager::close_connection($conn);
    return $found;
}

function get_kecamatan_from_username($username)
{
   
    $connection = MysqlManager::get_connection();
    $sql = "select a.kecamatan_id as kecamatan_id from access_groups a, users u where u.username ='$username' and u.group_id = a.id";
   
    $result = $connection->query($sql);
    check_error($connection);
    $row = $result->fetch_object();
    MysqlManager::close_connection($connection);
    return $row->kecamatan_id;
}

/*
 * built select input
 * @param $name select input name
 * @param $values an array consist each element "key"=>"value"
 * @param $selected_index default select input selected index
 * @param $attributes additional attributes;
 */
function __select_input($name, $values, $selected_id = 1, $attributes= '', $interceps = array())
{
    if(!is_array($values))
    {
        return "not array";
    }
    $result = "<select name='$name' $attributes id='$name'>";
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
    
    foreach($interceps as $row)
    {
        $option = "<option value='".$row['key']."'>".$row['value']."</option>";
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

function select_enum($table, $column, $selected_enum = '', $attributes='')
{    
    $conn = MysqlManager::get_connection();
    $sql = "show columns from $table like '$column'";
    $result = $conn->query($sql);
    check_error($conn);
    $row = $result->fetch_array();
    $str = str_replace("'","", substr($row[1],6,strlen($row[1])-7));
    $array = split(",", $str);
    MysqlManager::close_connection($conn);
    $selected_index = 0;
    if(sizeof($selected_enum) > 0)
    {
        $selected_index = __selected_index($array, $selected_enum);
    }
    return __select_input($column, $array, $selected_index, $attributes);
}

function select_enum_without_default_value($table, $column, $attributes='')
{    
    $conn = MysqlManager::get_connection();
    $sql = "show columns from $table like '$column'";
    $result = $conn->query($sql);
    check_error($conn);
    $row = $result->fetch_array();    
    $str = str_replace("'","", substr($row[1], 6, strlen($row[1]) - 7));
    MysqlManager::close_connection($conn);
    
    $array = split(",", $str);
    $result = "<select name='$column' $attributes >";
    foreach($array as $item)
    {            
        $option = "<option value='".$item."'";       
        $option .= ">".$item."</option>";
        $result .= $option;
    }
    $result .= "</select>";
    return $result;
}

function select($table, $key, $value, $select_name, $attributes='', $where = "", $selected_key = 1, $interceps = array())
{    
    $conn = MysqlManager::get_connection();
    $sql = "select $key as k , $value as val from $table";
    if(strlen($where) > 1)
    {
        $sql = "select $key as k, $value as val from $table where $where";
    }
   
    $list = array();
    $result = $conn->query($sql);
    check_error($conn);
    while($row = $result->fetch_object())
    {
        $list[] = array("key" => $row->k, "value" => $row->val);
    }    
    MysqlManager::close_connection($conn);
    return __select_input($select_name, $list, $selected_key, $attributes, $interceps);
}

function get_capil_kua_key(){
    $add = array();
    $add[] = array("key"=>CAPIL_KEY, "value"=>"Capil");
    $add[] = array("key"=>KUA_KEY, "value"=>"KUA");
    return $add;
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

function CalculateAge($dob){
   $d1 = strtotime($dob);
   $d2 = strtotime("now");
   $age = 0;
   while($d2 > $d1 = strtotime("+1 year", $d1)){
        ++$age;
   }
   return $age;
}
?>
