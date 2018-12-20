<?php
session_start();

function inisession() {   //valom sesijos kintamuosius

        $_SESSION['message']="";
        $_SESSION['user']="";
        $_SESSION['ulevel']=0;
        $_SESSION['userid']=0;
        $_SESSION['umail']=0;

    $_SESSION['name_login']="";
    $_SESSION['pass_login']="";
    $_SESSION['mail_login']="";
    $_SESSION['name']="";
    $_SESSION['phone']="";
    $_SESSION['name_error']="";
    $_SESSION['pass_error']="";
    $_SESSION['mail_error']="";
}

function checkname ($username){
if (!$username || strlen($username = trim($username)) == 0)
{$_SESSION['name_error']=
"<font size=\"2\" color=\"#ff0000\">* Neįvestas vartotojo vardas</font>";
"";
return false;}
elseif (!preg_match("/^([0-9a-zA-Z])*$/", $username))  /* Check if username is not alphanumeric */
{$_SESSION['name_error']=
"<font size=\"2\" color=\"#ff0000\">* Vartotojo vardas gali būti sudarytas<br>
    &nbsp;&nbsp;tik iš raidžių ir skaičių</font>";
return false;}
else return true;
}

function checkpass($pwd,$dbpwd) {     //  slaptazodzio tikrinimas (tik demo: min 4 raides ir/ar skaiciai) ir ar sutampa su DB esanciu

if (!$pwd || strlen($pwd = trim($pwd)) == 0)
{$_SESSION['pass_error']=
"<font size=\"2\" color=\"#ff0000\">* Neįvestas slaptažodis</font>";
return false;}
elseif (!preg_match("/^([0-9a-zA-Z])*$/", $pwd))  /* Check if $pass is not alphanumeric */
{$_SESSION['pass_error']="* Čia slaptažodis gali būti sudarytas<br>&nbsp;&nbsp;tik iš raidžių ir skaičių";
return false;}
elseif (strlen($pwd)<4)  // per trumpas
{$_SESSION['pass_error']=
"<font size=\"2\" color=\"#ff0000\">* Slaptažodžio ilgis <4 simbolius</font>";
return false;}
elseif ($dbpwd != substr(hash( 'sha256', $pwd ),5,32))
//elseif ($dbpwd != $pwd)
{ //var_dump($dbpwd);
//  xdebug_break();
$_SESSION['pass_error']=
"<font size=\"2\" color=\"#ff0000\">* Neteisingas slaptažodis</font>";
return false;}
else return true;
}

function checkdb($username) {  // iesko DB pagal varda, grazina {vardas,slaptazodis,lygis,id} ir nustato name_error
$db=mysqli_connect('localhost', 'root', '', 'schedule');
$sql = "SELECT * FROM person WHERE username = '$username'";
$result = mysqli_query($db, $sql);
var_dump($result);
$uname = $upass = $ulevel = $uid = $umail = null;
if (!$result || (mysqli_num_rows($result) != 1))   // jei >1 tai DB vardas kartojasi, netikrinu, imu pirma
{  // neradom vartotojo DB
$_SESSION['name_error']=
"<font size=\"2\" color=\"#ff0000\">* Tokio vartotojo nėra</font>";
}
else {  //vardas yra DB
$row = mysqli_fetch_assoc($result);
$uname= $row["username"]; $upass= $row["password"];
$ulevel=$row["userlevel"]; $uid= $row["id_Person"]; $umail = $row["email"];}
return array($uname,$upass,$ulevel,$uid,$umail);
}

function checkmail($mail) {// e-mail sintax error checking
if (!$mail || strlen($mail = trim($mail)) == 0)
{$_SESSION['mail_error']=
"<font size=\"2\" color=\"#ff0000\">* Neįvestas e-pašto adresas</font>";
return false;}
elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL))
{
    $_SESSION['mail_error']=
"<font size=\"2\" color=\"#ff0000\">* Neteisingas e-pašto adreso formatas</font>";
return false;}
else return true;
}


class Calendar
{

    /**
     * Constructor
     */
    public function __construct()
    {

        $str = "http://localhost/DaySchedule/public/Main";
        $this->naviHref = htmlentities($str);


        $str2 = "http://localhost/DaySchedule/public/Day";
        $this->naviToDay = htmlentities($str2);
    }

    /********************* PROPERTY ********************/
    private $dayLabels = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");

    private $currentYear = 0;

    private $currentMonth = 0;

    private $currentDay = 0;

    private $currentDate = null;

    private $daysInMonth = 0;

    private $naviHref = null;

    /********************* PUBLIC **********************/

    /**
     * print out the calendar
     */
    public function show()
    {
        $year = null;

        $month = null;

        if (null == $year && isset($_GET['year'])) {

            $year = $_GET['year'];

        } else if (null == $year) {

            $year = date("Y", time());

        }

        if (null == $month && isset($_GET['month'])) {

            $month = $_GET['month'];

        } else if (null == $month) {

            $month = date("m", time());

        }

        $this->currentYear = $year;

        $this->currentMonth = $month;

        $this->daysInMonth = $this->_daysInMonth($month, $year);

        $content = '<div id="calendar">' .
            '<div class="box">' .
            $this->_createNavi() .
            '</div>' .
            '<div class="box-content">' .
            '<ul class="label">' . $this->_createLabels() . '</ul>';
        $content .= '<div class="clear"></div>';
        $content .= '<ul class="dates">';

        $weeksInMonth = $this->_weeksInMonth($month, $year);
        // Create weeks in a month
        for ($i = 0; $i < $weeksInMonth; $i++) {

            //Create days in a week
            for ($j = 1; $j <= 7; $j++) {
                $content .= $this->_showDay($i * 7 + $j);
            }
        }

        $content .= '</ul>';

        $content .= '<div class="clear"></div>';

        $content .= '</div>';

        $content .= '</div>';
        return $content;
    }

    /********************* PRIVATE **********************/
    /**
     * create the li element for ul
     */
    private function _showDay($cellNumber)
    {

        if ($this->currentDay == 0) {

            $firstDayOfTheWeek = date('N', strtotime($this->currentYear . '-' . $this->currentMonth . '-01'));

            if (intval($cellNumber) == intval($firstDayOfTheWeek)) {

                $this->currentDay = 1;

            }
        }

        if (($this->currentDay != 0) && ($this->currentDay <= $this->daysInMonth)) {

            $this->currentDate = date('Y-m-d', strtotime($this->currentYear . '-' . $this->currentMonth . '-' . ($this->currentDay)));

            $cellContent = $this->currentDay;

            $this->currentDay++;

        } else {

            $this->currentDate = null;

            $cellContent = null;
        }


        return '<li id="li-' . $this->currentDate . '" class="' . ($cellNumber % 7 == 1 ? ' start ' : ($cellNumber % 7 == 0 ? ' end ' : ' ')) .
            ($cellContent == null ? 'mask' : '') . '">' . $cellContent . '</li>';
    }

    private function clicked()
    {


    }
    /**
     * create navigation
     */
    private function _createNavi()
    {

        $nextMonth = $this->currentMonth == 12 ? 1 : intval($this->currentMonth) + 1;

        $nextYear = $this->currentMonth == 12 ? intval($this->currentYear) + 1 : $this->currentYear;

        $preMonth = $this->currentMonth == 1 ? 12 : intval($this->currentMonth) - 1;

        $preYear = $this->currentMonth == 1 ? intval($this->currentYear) - 1 : $this->currentYear;

        $Main="Main";

        return
            '<div class="header">' .
            '<a class="prev" href="' . $this->naviHref . '?month=' . sprintf('%02d', $preMonth) . '&year=' . $preYear . '">Prev</a>' .
            '<span class="title">' . date('Y M', strtotime($this->currentYear . '-' . $this->currentMonth . '-1')) . '</span>' .
            '<a class="next" href="' . $this->naviHref . '?month=' . sprintf("%02d", $nextMonth) . '&year=' . $nextYear . '">Next</a>' .
            '</div>';
    }

    /**
     * create calendar week labels
     */
    private function _createLabels()
    {

        $content = '';

        foreach ($this->dayLabels as $index => $label) {

            $content .= '<li class="' . ($label == 6 ? 'end title' : 'start title') . ' title">' . $label . '</li>';

        }

        return $content;
    }




    /**
     * calculate number of weeks in a particular month
     */
    private function _weeksInMonth($month = null, $year = null)
    {

        if (null == ($year)) {
            $year = date("Y", time());
        }

        if (null == ($month)) {
            $month = date("m", time());
        }

        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month, $year);

        $numOfweeks = ($daysInMonths % 7 == 0 ? 0 : 1) + intval($daysInMonths / 7);

        $monthEndingDay = date('N', strtotime($year . '-' . $month . '-' . $daysInMonths));

        $monthStartDay = date('N', strtotime($year . '-' . $month . '-01'));

        if ($monthEndingDay < $monthStartDay) {

            $numOfweeks++;

        }

        return $numOfweeks;
    }

    /**
     * calculate number of days in a particular month
     */
    private function _daysInMonth($month = null, $year = null)
    {

        if (null == ($year))
            $year = date("Y", time());

        if (null == ($month))
            $month = date("m", time());

        return date('t', strtotime($year . '-' . $month . '-01'));
    }

}


?>