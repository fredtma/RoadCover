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
   var cnt   = 0;
   do {
      var target_date = tmp_date.setDate(tmp_date.getDate()+option);
      cnt++;
   } while (dateFormat(target_date,'ddd')!=cnt_week );
   return target_date;
}//endfunction

function getToday(){
   var d=new Date();
   var dd=d.getDate();var mm=(parseInt(d.getMonth())+1);var yy=d.getFullYear();var hh=d.getHours();var m=d.getMinutes();var s=d.getSeconds();
   dd=dd<10?'0'+dd:dd;mm=mm<10?'0'+mm:mm;m=m<10?'0'+m:m;hh=hh<10?'0'+hh:hh;s=s<10?'0'+s:s;
   return yy+'-'+mm+'-'+dd+' '+hh+':'+m+':'+s;
}
//=============================================================================//MD5 LIBRARY
function md5cycle(x, k) {
   var a = x[0], b = x[1], c = x[2], d = x[3];

   a = ff(a, b, c, d, k[0], 7, -680876936);
   d = ff(d, a, b, c, k[1], 12, -389564586);
   c = ff(c, d, a, b, k[2], 17, 606105819);
   b = ff(b, c, d, a, k[3], 22, -1044525330);
   a = ff(a, b, c, d, k[4], 7, -176418897);
   d = ff(d, a, b, c, k[5], 12, 1200080426);
   c = ff(c, d, a, b, k[6], 17, -1473231341);
   b = ff(b, c, d, a, k[7], 22, -45705983);
   a = ff(a, b, c, d, k[8], 7, 1770035416);
   d = ff(d, a, b, c, k[9], 12, -1958414417);
   c = ff(c, d, a, b, k[10], 17, -42063);
   b = ff(b, c, d, a, k[11], 22, -1990404162);
   a = ff(a, b, c, d, k[12], 7, 1804603682);
   d = ff(d, a, b, c, k[13], 12, -40341101);
   c = ff(c, d, a, b, k[14], 17, -1502002290);
   b = ff(b, c, d, a, k[15], 22, 1236535329);

   a = gg(a, b, c, d, k[1], 5, -165796510);
   d = gg(d, a, b, c, k[6], 9, -1069501632);
   c = gg(c, d, a, b, k[11], 14, 643717713);
   b = gg(b, c, d, a, k[0], 20, -373897302);
   a = gg(a, b, c, d, k[5], 5, -701558691);
   d = gg(d, a, b, c, k[10], 9, 38016083);
   c = gg(c, d, a, b, k[15], 14, -660478335);
   b = gg(b, c, d, a, k[4], 20, -405537848);
   a = gg(a, b, c, d, k[9], 5, 568446438);
   d = gg(d, a, b, c, k[14], 9, -1019803690);
   c = gg(c, d, a, b, k[3], 14, -187363961);
   b = gg(b, c, d, a, k[8], 20, 1163531501);
   a = gg(a, b, c, d, k[13], 5, -1444681467);
   d = gg(d, a, b, c, k[2], 9, -51403784);
   c = gg(c, d, a, b, k[7], 14, 1735328473);
   b = gg(b, c, d, a, k[12], 20, -1926607734);

   a = hh(a, b, c, d, k[5], 4, -378558);
   d = hh(d, a, b, c, k[8], 11, -2022574463);
   c = hh(c, d, a, b, k[11], 16, 1839030562);
   b = hh(b, c, d, a, k[14], 23, -35309556);
   a = hh(a, b, c, d, k[1], 4, -1530992060);
   d = hh(d, a, b, c, k[4], 11, 1272893353);
   c = hh(c, d, a, b, k[7], 16, -155497632);
   b = hh(b, c, d, a, k[10], 23, -1094730640);
   a = hh(a, b, c, d, k[13], 4, 681279174);
   d = hh(d, a, b, c, k[0], 11, -358537222);
   c = hh(c, d, a, b, k[3], 16, -722521979);
   b = hh(b, c, d, a, k[6], 23, 76029189);
   a = hh(a, b, c, d, k[9], 4, -640364487);
   d = hh(d, a, b, c, k[12], 11, -421815835);
   c = hh(c, d, a, b, k[15], 16, 530742520);
   b = hh(b, c, d, a, k[2], 23, -995338651);

   a = ii(a, b, c, d, k[0], 6, -198630844);
   d = ii(d, a, b, c, k[7], 10, 1126891415);
   c = ii(c, d, a, b, k[14], 15, -1416354905);
   b = ii(b, c, d, a, k[5], 21, -57434055);
   a = ii(a, b, c, d, k[12], 6, 1700485571);
   d = ii(d, a, b, c, k[3], 10, -1894986606);
   c = ii(c, d, a, b, k[10], 15, -1051523);
   b = ii(b, c, d, a, k[1], 21, -2054922799);
   a = ii(a, b, c, d, k[8], 6, 1873313359);
   d = ii(d, a, b, c, k[15], 10, -30611744);
   c = ii(c, d, a, b, k[6], 15, -1560198380);
   b = ii(b, c, d, a, k[13], 21, 1309151649);
   a = ii(a, b, c, d, k[4], 6, -145523070);
   d = ii(d, a, b, c, k[11], 10, -1120210379);
   c = ii(c, d, a, b, k[2], 15, 718787259);
   b = ii(b, c, d, a, k[9], 21, -343485551);

   x[0] = add32(a, x[0]);
   x[1] = add32(b, x[1]);
   x[2] = add32(c, x[2]);
   x[3] = add32(d, x[3]);

}
function cmn(q, a, b, x, s, t) {
   a = add32(add32(a, q), add32(x, t));
   return add32((a << s) | (a >>> (32 - s)), b);
}
function ff(a, b, c, d, x, s, t) {
   return cmn((b & c) | ((~b) & d), a, b, x, s, t);
}
function gg(a, b, c, d, x, s, t) {
   return cmn((b & d) | (c & (~d)), a, b, x, s, t);
}
function hh(a, b, c, d, x, s, t) {
   return cmn(b ^ c ^ d, a, b, x, s, t);
}
function ii(a, b, c, d, x, s, t) {
   return cmn(c ^ (b | (~d)), a, b, x, s, t);
}
function md51(s) {
   txt = '';
   var n = s.length,
           state = [1732584193, -271733879, -1732584194, 271733878], i;
   for (i = 64; i <= s.length; i += 64) {
      md5cycle(state, md5blk(s.substring(i - 64, i)));
   }
   s = s.substring(i - 64);
   var tail = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
   for (i = 0; i < s.length; i++)
      tail[i >> 2] |= s.charCodeAt(i) << ((i % 4) << 3);
   tail[i >> 2] |= 0x80 << ((i % 4) << 3);
   if (i > 55) {
      md5cycle(state, tail);
      for (i = 0; i < 16; i++)
         tail[i] = 0;
   }
   tail[14] = n * 8;
   md5cycle(state, tail);
   return state;
}
/* there needs to be support for Unicode here,
 * unless we pretend that we can redefine the MD-5
 * algorithm for multi-byte characters (perhaps
 * by adding every four 16-bit characters and
 * shortening the sum to 32 bits). Otherwise
 * I suggest performing MD-5 as if every character
 * was two bytes--e.g., 0040 0025 = @%--but then
 * how will an ordinary MD-5 sum be matched?
 * There is no way to standardize text to something
 * like UTF-8 before transformation; speed cost is
 * utterly prohibitive. The JavaScript standard
 * itself needs to look at this: it should start
 * providing access to strings as preformed UTF-8
 * 8-bit unsigned value arrays.
 */
function md5blk(s) { /* I figured global was faster.   */
   var md5blks = [], i; /* Andy King said do it this way. */
   for (i = 0; i < 64; i += 4) {
      md5blks[i >> 2] = s.charCodeAt(i)
              + (s.charCodeAt(i + 1) << 8)
              + (s.charCodeAt(i + 2) << 16)
              + (s.charCodeAt(i + 3) << 24);
   }
   return md5blks;
}
var hex_chr = '0123456789abcdef'.split('');
function rhex(n)
{
   var s = '', j = 0;
   for (; j < 4; j++)
      s += hex_chr[(n >> (j * 8 + 4)) & 0x0F]
              + hex_chr[(n >> (j * 8)) & 0x0F];
   return s;
}
function hex(x) {
   for (var i = 0; i < x.length; i++)
      x[i] = rhex(x[i]);
   return x.join('');
}
function md5(s) {
   return hex(md51(s));
}
/* this function is much faster,
 so if possible we use it. Some IEs
 are the only ones I know of that
 need the idiotic second function,
 generated by an if clause.  */
function add32(a, b) {
   return (a + b) & 0xFFFFFFFF;
}
if (md5('hello') != '5d41402abc4b2a76b9719d911017c592') {
   function add32(x, y) {
      var lsw = (x & 0xFFFF) + (y & 0xFFFF),
              msw = (x >> 16) + (y >> 16) + (lsw >> 16);
      return (msw << 16) | (lsw & 0xFFFF);
   }
}
//=============================================================================//