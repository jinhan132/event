	var target;
	var stime;
	document.write("<div id=minical oncontextmenu='return false' ondragstart='return false' onselectstart='return false' style=\"width:180px; background:buttonface; margin:0; padding:0;margin-top:0;width:180;display:none;position:absolute; z-index: 9999;border: 1px solid black;\"></div>");

function Calendar(obj) {

	var now = obj.value.split("-");
	var x, y;
	
	target = obj;																

	if (1 == 2) //baenawa
	{
		x = (document.layers) ? loc.pageX : event.clientX;
		y = (document.layers) ? loc.pageY : event.clientY;

		minical.style.top = y+5 + document.body.scrollTop;
		minical.style.left = x-50 + document.body.scrollLeft;
	} else {
		x = (document.layers) ? loc.pageX : event.clientX;
		y = (document.layers) ? loc.pageY : event.clientY;

		minical.style.pixelTop	= y+5 + document.body.scrollTop;
		minical.style.pixelLeft	= x-50 + document.body.scrollLeft;
	}

	minical.style.display = (minical.style.display == "block") ? "none" : "block";

	if (now.length == 3) {														
		Show_cal(now[0],now[1],now[2]);											
	} else {
		now = new Date();
		Show_cal(now.getFullYear(), now.getMonth()+1, now.getDate());			
	}

}
	
function doOver() {																
	var el = window.event.srcElement;
	cal_Day = el.title;

	if (cal_Day.length > 7) {													
		el.style.borderTopColor = el.style.borderLeftColor = "buttonhighlight";
		el.style.borderRightColor = el.style.borderBottomColor = "buttonshadow";
	}
	window.clearTimeout(stime);													
}

function doClick() {															
	cal_Day = window.event.srcElement.title;
	window.event.srcElement.style.borderColor = "red";							
	if (cal_Day.length > 7) {													
		target.value=cal_Day													
	}
	minical.style.display='none';												
}

function doOut() {
	var el = window.event.fromElement;
	cal_Day = el.title;

	if (cal_Day.length > 7) {
		el.style.borderColor = "white";
	}
	//stime=window.setTimeout("minical.style.display='none';", 200);
}

function day2(d) {																
	var str = new String();
	
	if (parseInt(d) < 10) {
		str = "0" + parseInt(d);
	} else {
		str = "" + parseInt(d);
	}
	return str;
}

function Show_cal(sYear, sMonth, sDay) {
	var Months_day = new Array(0,31,28,31,30,31,30,31,31,30,31,30,31)
	var Weekday_name = new Array("Su", "Mo", "Te", "We", "Tu", "Fr", "Sa");
	var intThisYear = new Number(), intThisMonth = new Number(), intThisDay = new Number();
	document.all.minical.innerHTML = "";
	datToday = new Date();													
	
	intThisYear = parseInt(sYear);
	intThisMonth = parseInt(sMonth);
	intThisDay = parseInt(sDay);
	
	if (intThisYear == 0) intThisYear = datToday.getFullYear();				
	if (intThisMonth == 0) intThisMonth = parseInt(datToday.getMonth())+1;	
	if (intThisDay == 0) intThisDay = datToday.getDate();
	
	switch(intThisMonth) {
		case 1:
				intPrevYear = intThisYear -1;
				intPrevMonth = 12;
				intPrevDay = Months_day[intPrevMonth] +1;
				intNextYear = intThisYear;
				intNextMonth = 2;
				break;
		case 12:
				intPrevYear = intThisYear;
				intPrevMonth = 11;
				intPrevDay = Months_day[intThisMonth] +1;
				intNextYear = intThisYear + 1;
				intNextMonth = 1;
				break;
		default:
				intPrevYear = intThisYear;
				intPrevMonth = parseInt(intThisMonth) - 1;
				intPrevDay = Months_day[intPrevMonth] +1;
				intNextYear = intThisYear;
				intNextMonth = parseInt(intThisMonth) + 1;
				break;
	}

	NowThisYear = datToday.getFullYear();										
	NowThisMonth = datToday.getMonth()+1;										
	NowThisDay = datToday.getDate();											

	DNowThisYear = datToday.getFullYear();										
	DNowThisMonth = datToday.getMonth()+1;										
	DNowThisDay = datToday.getDate();											

	datFirstDay = new Date(intThisYear, intThisMonth-1, 1);						
	intFirstWeekday = datFirstDay.getDay();										
	
	intSecondWeekday = intFirstWeekday;
	intThirdWeekday = intFirstWeekday;
	
	datThisDay = new Date(intThisYear, intThisMonth, intThisDay);				
	intThisWeekday = datThisDay.getDay();										

	varThisWeekday = Weekday_name[intThisWeekday];								
	
	intPrintDay = 1																
	secondPrintDay = 1
	thirdPrintDay = 1
	
	Stop_Flag = 0
	
	if ((intThisYear % 4)==0) {													
		if ((intThisYear % 100) == 0) {
			if ((intThisYear % 400) == 0) {
				Months_day[2] = 29;
			}
		} else {
			Months_day[2] = 29;
		}
	}
	intLastDay = Months_day[intThisMonth];										
	Stop_flag = 0

	Cal_HTML = "<TABLE WIDTH=100% BORDER=0 CELLPADDING=0 CELLSPACING=0 ONMOUSEOVER=doOver(); ONMOUSEOUT=doOut(); STYLE='font-size:8pt;font-family:Tahoma;' bgcolor='#EDF0F5'>"
			+ "<TR ALIGN=CENTER><TD COLSPAN=7 nowrap=nowrap ALIGN=CENTER><SPAN TITLE='' STYLE=cursor:hand; onClick='Show_cal("+intPrevYear+","+intPrevMonth+",1);'> ◀ </SPAN> "
			+ "<B STYLE=color:red>"+get_Yearinfo(intThisYear,intThisMonth,intThisDay)+get_Monthinfo(intThisYear,intThisMonth,intThisDay)+"</B>"
			+ " <SPAN TITLE='' STYLE=cursor:hand; onClick='Show_cal("+intNextYear+","+intNextMonth+",1);'> ▶ </SPAN></TD></TR>"
			+ "</TABLE><table border=\"1\" cellspacing=\"0\" cellpadding=\"0\" bordercolordark=\"#ffffff\" bordercolorlight=\"#C4CEDC\" width=\"180\" align=\"center\"><TR ALIGN=CENTER  height=\"18\" bgcolor=\"#C4CEDC\"><TD><font color=\"#08246B\"><b>Su</b></font></TD><TD><font color=\"#08246B\"><b>Mo</b></font></TD><TD><font color=\"#08246B\"><b>Tu</b></font></TD><TD><font color=\"#08246B\"><b>We</b></font></TD><TD><font color=\"#08246B\"><b>Th</b></font></TD><TD><font color=\"#08246B\"><b>Fr</b></font></TD><TD><font color=\"#08246B\"><b>Sa</b></font></TD></TR>";

	for (intLoopWeek=1; intLoopWeek < 7; intLoopWeek++) {						
		Cal_HTML += "<TR ALIGN=CENTER>"
		for (intLoopDay=1; intLoopDay <= 7; intLoopDay++) {						
			if (intThirdWeekday > 0) {
				
				pevMonthDay = intPrevDay - intFirstWeekday;
				if(intThisMonth == 1){
					Cal_HTML += "<TD height=\"15\" onClick=doClick(); title="+intPrevYear+"-"+day2(intPrevMonth).toString()+"-"+day2(pevMonthDay).toString()+" STYLE=\"cursor:Hand;\" style=\"background-color:#F7F7FF;\">"+pevMonthDay;
				}else{
					Cal_HTML += "<TD height=\"15\" onClick=doClick(); title="+intThisYear+"-"+day2(intPrevMonth).toString()+"-"+day2(pevMonthDay).toString()+" STYLE=\"cursor:Hand;\" style=\"background-color:#F7F7FF;\">"+pevMonthDay;
				}
				intPrevDay++;
				intThirdWeekday--;
			} else {
				if (thirdPrintDay > intLastDay) {								
					NextPrintDay = thirdPrintDay-intLastDay;
					if(intThisMonth == 12){
						Cal_HTML += "<TD height=\"15\" onClick=doClick(); title="+intNextYear+"-"+day2(intNextMonth).toString()+"-"+day2(NextPrintDay).toString()+" STYLE=\"cursor:Hand;\" bgcolor=\"#F7F7FF\">"+(thirdPrintDay-intLastDay);
					}else{
						Cal_HTML += "<TD height=\"15\" onClick=doClick(); title="+intThisYear+"-"+day2(intNextMonth).toString()+"-"+day2(NextPrintDay).toString()+" STYLE=\"cursor:Hand;\" bgcolor=\"#F7F7FF\">"+(thirdPrintDay-intLastDay);
					}
				} else {														
					Cal_HTML += "<TD height=\"15\" onClick=doClick(); title="+intThisYear+"-"+day2(intThisMonth).toString()+"-"+day2(thirdPrintDay).toString()+" STYLE=\"cursor:Hand;\"";
					if (intThisYear == NowThisYear && intThisMonth==NowThisMonth && thirdPrintDay==intThisDay) {
						Cal_HTML += ";";
						Cal_HTML += "\" bgcolor=\"#A5E5F7\">"+thirdPrintDay+"";
					}else{
						Cal_HTML += "\" bgcolor=\"#FFFFFF\">"+thirdPrintDay;
					}
					
				}
				thirdPrintDay++;

				if (thirdPrintDay > intLastDay && thirdPrintDay%7==0) {								
					Stop_Flag = 1;
				}
			}
			Cal_HTML += "</TD>";
		}
		Cal_HTML += "</TR>";
		if (Stop_Flag==1) break;
	}
	Cal_HTML += "<tr><td colspan=\"7\" align=\"center\" bgcolor=\"#DAE1EB\" height=\"18\">Today(<a href=\"#\" onClick=doClick(); title=\""+DNowThisYear+"-"+day2(DNowThisMonth).toString()+"-"+day2(DNowThisDay).toString()+"\">"+DNowThisYear+"-"+day2(DNowThisMonth).toString()+"-"+day2(DNowThisDay).toString()+"</a>) | <a href=\"#\" style=\"color: black; text-decoration: none\" onClick=doClick();>Close</a></td></tr>"
	Cal_HTML += "</TABLE>";

	document.all.minical.innerHTML = Cal_HTML;
}

function get_Yearinfo(year,month,day) {											

	//var min = parseInt(year) - 100;
	//var max = parseInt(year) + 10;
	var min = 1999;
	var max = parseInt(year) + 10;
	var i = new Number();
	var str = new String();
	
	str = "<SELECT onChange='Show_cal(this.value,"+month+","+day+");' ONMOUSEOVER=doOver(); style='color:#333333'>";
	for (i=min; i<=max; i++) {
		if (i == parseInt(year)) {
			str += "<OPTION VALUE="+i+" selected ONMOUSEOVER=doOver(); style='background-color:#ffffff'>"+i+"</OPTION>";
		} else {
			str += "<OPTION VALUE="+i+" ONMOUSEOVER=doOver(); style='background-color:#ffffff'>"+i+"</OPTION>";
		}
	}
	str += "</SELECT>";
	return str;
}


function get_Monthinfo(year,month,day) {										
	var i = new Number();
	var str = new String();
	
	str = "<SELECT onChange='Show_cal("+year+",this.value,"+day+");' ONMOUSEOVER=doOver(); style='color:#333333'>";
	for (i=1; i<=12; i++) {
		if (i == parseInt(month)) {
			str += "<OPTION VALUE="+i+" selected ONMOUSEOVER=doOver(); style='background-color:#ffffff'>"+i+"</OPTION>";
		} else {
			str += "<OPTION VALUE="+i+" ONMOUSEOVER=doOver(); style='background-color:#ffffff'>"+i+"</OPTION>";
		}
	}
	str += "</SELECT>";
	return str;
}
