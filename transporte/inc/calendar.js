/* $Id: tbl_change.js,v 2.12 2004/05/13 15:21:41 nijel Exp $ */


/**
 * Modify from controls when the "NULL" checkbox is selected
 *
 * @param   string   the MySQL field type
 * @param   string   the urlencoded field name
 * @param   string   the md5 hashed field name
 *
 * @return  boolean  always true
 */
function nullify(theType, urlField, md5Field, multi_edit)
{
    var rowForm = document.forms['insertForm'];

    if (typeof(rowForm.elements['funcs' + multi_edit + '[' + urlField + ']']) != 'undefined') {
        rowForm.elements['funcs' + multi_edit + '[' + urlField + ']'].selectedIndex = -1;
    }

    // "SET" field , "ENUM" field with more than 20 characters
    // or foreign key field
    if (theType == 1 || theType == 3 || theType == 4) {
        rowForm.elements['field_' + md5Field + multi_edit + '[]'].selectedIndex = -1;
    }
    // Other "ENUM" field
    else if (theType == 2) {
        var elts     = rowForm.elements['field_' + md5Field + multi_edit + '[]'];
        // when there is just one option in ENUM:
        if (elts.checked) {
            elts.checked = false;
        } else {
            var elts_cnt = elts.length;
            for (var i = 0; i < elts_cnt; i++ ) {
                elts[i].checked = false;
            } // end for

        } // end if
    }
    // Other field types
    else /*if (theType == 5)*/ {
        rowForm.elements['fields' + multi_edit + '[' + urlField + ']'].value = '';
    } // end if... else if... else

    return true;
} // end of the 'nullify()' function


/**
 * Unchecks the "NULL" control when a function has been selected or a value
 * entered
 *
 * @param   string   the urlencoded field name
 *
 * @return  boolean  always true
 */
function unNullify(urlField, multi_edit)
{
    var rowForm = document.forms['insertForm'];

    if (typeof(rowForm.elements['fields_null[multi_edit][' + multi_edit + '][' + urlField + ']']) != 'undefined') {
        rowForm.elements['fields_null[multi_edit][' + multi_edit + '][' + urlField + ']'].checked = false
    } // end if
    
    if (typeof(rowForm.elements['insert_ignore_' + multi_edit]) != 'undefined') {
        rowForm.elements['insert_ignore_' + multi_edit].checked = false
    } // end if

    return true;
} // end of the 'unNullify()' function

/**
  * Allows moving around inputs/select by Ctrl+arrows
  *
  * @param   object   event data
  */
function onKeyDownArrowsHandler(e) {
    e = e||window.event;
    var o = (e.srcElement||e.target);
    if (!o) return;
    if (o.tagName != "TEXTAREA" && o.tagName != "INPUT" && o.tagName != "SELECT") return;
    if (!e.ctrlKey) return;
    if (!o.id) return;

    var pos = o.id.split("_");
    if (pos[0] != "field" || typeof pos[2] == "undefined") return;

    var x = pos[2], y=pos[1];

    // skip non existent fields
    for (i=0; i<10; i++)
    {
        switch(e.keyCode) {
            case 38: y--; break; // up
            case 40: y++; break; // down
            case 37: x--; break; // left
            case 39: x++; break; // right
            default: return;
        }

        var id = "field_" + y + "_" + x;
        var nO = document.getElementById(id);
        if (!nO) {
            var id = "field_" + y + "_" + x + "_0";
            var nO = document.getElementById(id);
        }
        if (nO) break;
    }

    if (!nO) return;
    nO.focus();
    if (nO.tagName != 'SELECT') {
        nO.select();
    }
    e.returnValue = false;
}


var day;
var month;
var year;
var hour;
var minute;
var second;
var clock_set = 0;
var dia;
var mes;
var hora;
var minuto;
var segundo;
/**
 * Opens calendar window.
 *
 * @param   string      calendar.php parameters
 * @param   string      form name
 * @param   string      field name
 * @param   string      edit type - date/timestamp
 */
function openCalendar(params, form, field, /*changed,*/ type) {
    window.open("inc/calendar.php?" + params, "calendar", "width=400,height=200,status=yes");
    dateField = eval("document." + form + "." + field);
//	dateChanged = eval("document." + form + "." + changed);
    dateType = type;
}

/**
 * Formats number to two digits.
 *
 * @param   int number to format.
 */
function formatNum2(i, valtype) {
    f = (i < 10 ? '0' : '') + i;
    if (valtype && valtype != '') {
        switch(valtype) {
            case 'month':
                f = (f > 12 ? 12 : f);
                break;

            case 'day':
                f = (f > 31 ? 31 : f);
                break;

            case 'hour':
                f = (f > 24 ? 24 : f);
                break;

            default:
            case 'second':
            case 'minute':
                f = (f > 59 ? 59 : f);
                break;
        }
    }

    return f;
}

/**
 * Formats number to four digits.
 *
 * @param   int number to format.
 */
function formatNum4(i) {
    return (i < 1000 ? i < 100 ? i < 10 ? '000' : '00' : '0' : '') + i;
}

/**
 * Initializes calendar window.
 */
function initCalendar() {
    if (!year && !month && !day) {
        /* Called for first time */
        if (window.opener.dateField.value) {
            value = window.opener.dateField.value;
            if (window.opener.dateType == 'datetime' || window.opener.dateType == 'date') {
                if (window.opener.dateType == 'datetime') {
                    parts   = value.split(' ');
                    value   = parts[0];

                    if (parts[1]) {
                        time    = parts[1].split(':');
                        hour    = parseInt(time[0]);
                        minute  = parseInt(time[1]);
                        second  = parseInt(time[2]);
                    }
                }

                date = value.split("-");
				//Hay que hacer lo siguiente con los nº 8 y 9 (en mes 9 y 10)

            	dia=date[0];
				if(dia=="08")
					dia=8;
				if(dia=="09")
					dia=9;
				mes=date[1];
				if(mes=="08")	
					mes=8;
				if(mes=="09")
					mes=9;
                day         = parseInt(dia);
                month       = parseInt(mes) - 1;
               year        = parseInt(date[2]);
            } else {
			dia=value.substr(0,2);
				if(dia=="08")
					dia=8;
				if(dia=="09")
					dia=9;
				mes=value.substr(3,2);
				if(mes=="08")	
					mes=8;
				if(mes=="09")
					mes=9;
				hora=value.substr(11,2);
				if(hora=="08")
					hora=8;
				if(hora=="09")
					hora=9;
				minuto=value.substr(14,2);
				if(minuto=="08")	
					minuto=8;
				if(minuto=="09")
					minuto=9;
				segundo=value.substr(17,2);
				if(segundo=="08")	
					segundo=8;
				if(mes=="09")
					segundo=9;
                day        = parseInt(dia);
                month       = parseInt(mes) - 1;
                year        = parseInt(value.substr(6,4));
                hour        = parseInt(hora);
                minute      = parseInt(minuto);
                second      = parseInt(segundo);
            }
        }
		
        if (isNaN(year) || isNaN(month) || isNaN(day) || day == 0) {
            dt      = new Date();
            year    = dt.getFullYear();
            month   = dt.getMonth();
            day     = dt.getDate();
        }
        if (isNaN(hour) || isNaN(minute) || isNaN(second)) {
            dt      = new Date();
            hour    = dt.getHours();
            minute  = dt.getMinutes();
            second  = dt.getSeconds();
        }
    } else {
        /* Moving in calendar */
        if (month > 11) {
            month = 0;
            year++;
        }
        if (month < 0) {
            month = 11;
            year--;
        }
    }

    if (document.getElementById) {
        cnt = document.getElementById("calendar_data");
    } else if (document.all) {
        cnt = document.all["calendar_data"];
    }


    cnt.innerHTML = "";

    str = ""

    //heading table
	//str += '<table class="calendar2"><tr><th width="100%">&nbsp;</th></tr></table>';
    str += '<table class="calendar2"><tr><th width="50%">';
    str += '<a href="#" onclick="month--; initCalendar();">&laquo;</a> ';
    str += month_names[month];
    str += ' <a href="#" onclick="month++; initCalendar();">&raquo;</a>';
    str += '</th><th width="50%">';
	str += '<a href="#" onclick="year-=10; initCalendar();">&laquo;&laquo;</a> ';
    str += '<a href="#" onclick="year--; initCalendar();">&laquo;</a> ';
    str += year;
    str += ' <a href="#" onclick="year++; initCalendar();">&raquo;</a>';
	str += ' <a href="#" onclick="year+=10; initCalendar();">&raquo;&raquo;</a>';
    str += '</th></tr></table>';

    str += '<table class="calendar"><tr>';
    for (i = 0; i < 7; i++) {
        str += "<th>" + day_names[i] + "</th>";
    }
    str += "</tr>";

    var firstDay = new Date(year, month, 1).getDay();
    var lastDay = new Date(year, month + 1, 0).getDate();

    str += "<tr>";

    dayInWeek = 0;
    for (i = 0; i < firstDay; i++) {
        str += "<td>&nbsp;</td>";
        dayInWeek++;
    }
    for (i = 1; i <= lastDay; i++) {
        if (dayInWeek == 7) {
            str += "</tr><tr>";
            dayInWeek = 0;
        }

        dispmonth = 1 + month;

        if (window.opener.dateType == 'datetime' || window.opener.dateType == 'date') {
            actVal = formatNum2(i, 'day') + "-" + formatNum2(dispmonth, 'month') + "-" + formatNum4(year);
        } else {
            actVal = "" + formatNum2(i, 'day') +  + formatNum2(dispmonth, 'month') + formatNum4(year);	
        }
        if (i == day) {
            style = ' class="selected"';
        } else {
            style = '';
        }
        str += "<td" + style + "><a href='#' onclick='returnDate(\"" + actVal + "\");'>" + i + "</a></td>"
        dayInWeek++;
    }
    for (i = dayInWeek; i < 7; i++) {
        str += "<td>&nbsp;</td>";
    }

    str += "</tr></table>";
	str += '<table class="calendar2"><tr><th width="100%">&nbsp;</th></tr></table>';

    cnt.innerHTML = str;

    // Should we handle time also?
    if (window.opener.dateType != 'date' && !clock_set) {

        if (document.getElementById) {
            cnt = document.getElementById("clock_data");
        } else if (document.all) {
            cnt = document.all["clock_data"];
        }

        str = '';
        str += '<form class="clock">';
        str += '<input id="hour"    type="text" size="2" maxlength="2" onblur="this.value=formatNum2(this.value, \'hour\')" value="' + formatNum2(hour, 'hour') + '" />:';
        str += '<input id="minute"  type="text" size="2" maxlength="2" onblur="this.value=formatNum2(this.value, \'minute\')" value="' + formatNum2(minute, 'minute') + '" />:';
        str += '<input id="second"  type="text" size="2" maxlength="2" onblur="this.value=formatNum2(this.value, \'second\')" value="' + formatNum2(second, 'second') + '" />';
        str += '</form>';

        cnt.innerHTML = str;
        clock_set = 1;
    }

}

/**
 * Returns date from calendar.
 *
 * @param   string     date text
 * @param	string	   date text changed
 */
function returnDate(d) {
    txt = d;

    if (window.opener.dateType != 'date') {
        // need to get time
        h = parseInt(document.getElementById('hour').value);
        m = parseInt(document.getElementById('minute').value);
        s = parseInt(document.getElementById('second').value);
        if (window.opener.dateType == 'datetime') {			
            txt += ' ' + formatNum2(h, 'hour') + ':' + formatNum2(m, 'minute') + ':' + formatNum2(s, 'second');
        } else {
            // timestamp
            txt += formatNum2(h, 'hour') + formatNum2(m, 'minute') + formatNum2(s, 'second');
        }
    }

    window.opener.dateField.value = txt;
    window.close();
}
