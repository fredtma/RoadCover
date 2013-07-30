//============================================================================// date formate functuion from @ http://blog.stevenlevithan.com/archives/date-time-format
var dateFormat = function () {
   var	token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
   timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
   timezoneClip = /[^-+\dA-Z]/g,
   pad = function (val, len) {
      val = String(val);
      len = len || 2;
      while (val.length < len) val = "0" + val;
      return val;
   };

   // Regexes and supporting functions are cached through closure
   return function (date, mask, utc) {
      var dF = dateFormat;

      // You can't provide utc if you skip other args (use the "UTC:" mask prefix)
      if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) {
         mask = date;
         date = undefined;
      }

      // Passing date through Date applies Date.parse, if necessary
      date = date ? new Date(date) : new Date;
      if (isNaN(date)) throw SyntaxError("invalid date");

      mask = String(dF.masks[mask] || mask || dF.masks["default"]);

      // Allow setting the utc argument via the mask
      if (mask.slice(0, 4) == "UTC:") {
         mask = mask.slice(4);
         utc = true;
      }

      var	_ = utc ? "getUTC" : "get",
      d = date[_ + "Date"](),
      D = date[_ + "Day"](),
      m = date[_ + "Month"](),
      y = date[_ + "FullYear"](),
      H = date[_ + "Hours"](),
      M = date[_ + "Minutes"](),
      s = date[_ + "Seconds"](),
      L = date[_ + "Milliseconds"](),
      o = utc ? 0 : date.getTimezoneOffset(),
      flags = {
         d:    d,
         dd:   pad(d),
         ddd:  dF.i18n.dayNames[D],
         dddd: dF.i18n.dayNames[D + 7],
         m:    m + 1,
         mm:   pad(m + 1),
         mmm:  dF.i18n.monthNames[m],
         mmmm: dF.i18n.monthNames[m + 12],
         yy:   String(y).slice(2),
         yyyy: y,
         h:    H % 12 || 12,
         hh:   pad(H % 12 || 12),
         H:    H,
         HH:   pad(H),
         M:    M,
         MM:   pad(M),
         s:    s,
         ss:   pad(s),
         l:    pad(L, 3),
         L:    pad(L > 99 ? Math.round(L / 10) : L),
         t:    H < 12 ? "a"  : "p",
         tt:   H < 12 ? "am" : "pm",
         T:    H < 12 ? "A"  : "P",
         TT:   H < 12 ? "AM" : "PM",
         Z:    utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
         o:    (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
         S:    ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
      };

      return mask.replace(token, function ($0) {
         return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
      });
   };
}();

// Some common format strings
dateFormat.masks = {
   "default":      "ddd mmm dd yyyy HH:MM:ss",
   shortDate:      "m/d/yy",
   mediumDate:     "mmm d, yyyy",
   longDate:       "mmmm d, yyyy",
   fullDate:       "dddd, mmmm d, yyyy",
   shortTime:      "h:MM TT",
   mediumTime:     "h:MM:ss TT",
   longTime:       "h:MM:ss TT Z",
   isoDate:        "yyyy-mm-dd",
   isoTime:        "HH:MM:ss",
   isoDateTime:    "yyyy-mm-dd HH:MM:ss",
   isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
};

// Internationalization strings
dateFormat.i18n = {
   dayNames: [
   "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
   "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
   ],
   monthNames: [
   "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
   "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
   ]
};

// For convenience...
Date.prototype.format = function (mask, utc) {
   return dateFormat(this, mask, utc);
};
//get the week number
Date.prototype.getWeek = function () {
   // Create a copy of this date object
   var target  = new Date(this.valueOf());

   // ISO week date weeks start on monday
   // so correct the day number
   //var dayNr   = (this.getDay() + 6) % 7; //if monday is the start of the week
   var dayNr   = this.getDay();
   // Set the target to the thursday of this week so the
   // target date is in the right year
   //target.setDate(target.getDate() - dayNr + 3);  //if week start with monday
   target.setDate(target.getDate() - dayNr + 4);

   // ISO 8601 states that week 1 is the week
   // with january 4th in it
   var jan4    = new Date(target.getFullYear(), 0, 4);

   // Number of days between target date and january 4th
   var dayDiff = (target - jan4) / 86400000;

   // Calculate week number: Week 1 (january 4th) plus the
   // number of weeks between target date and january 4th
   //var weekNr = 1 + Math.ceil(dayDiff / 7);
   var weekNr = Math.ceil(dayDiff / 7);

   return weekNr;
}
Date.prototype.getWeekYear = function ()
{
   // Create a new date object for the thursday of this week
   var target  = new Date(this.valueOf());
   target.setDate(target.getDate() - this.getDay() + 4);

   return target.getFullYear();
}
/*calculate the numbr of days in a month
cal_days_in_month = function (iMonth, iYear) {
   return 32 - new Date(iYear, iMonth, 32).getDate();
}/*endfunction*/
/* Move to a specific date of the week in a month*/
moveToDayOfWeek = function (tmp_date, cnt_week, option, loop){

   option= (!option)?1:option;
   cnt   = 0;
   do {
      target_date = tmp_date.setDate(tmp_date.getDate()+option);
      cnt++;
   } while (dateFormat(target_date,'ddd')!=cnt_week );
   return target_date;
}//endfunction