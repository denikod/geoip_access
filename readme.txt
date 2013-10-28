==========================
 ExpressionEngine
 ------------------------
 Extension / GeoIp Access
 http://denik.od.ua/
==========================

Library: http://dev.maxmind.com/geoip/legacy/downloadable/
Database: http://dev.maxmind.com/geoip/legacy/geolite/

DataBases is placement in {EE}/lib/geoip
You can use 3 types of databases.
1. Countries - GeoIP.dat
2. Cities Lite - GeoLiteCity.dat
3. Cities (Paid) - GeoIPCity.dat (not included)
Extension itself selects database depending on the existing files.

Information is added to the global variables.

Usage:
<p><b>geo_code:</b>          {geo_code}</p>
<p><b>geo_country_code:</b>		{geo_country_code}</p>
<p><b>geo_country_name:</b>		{geo_country_name}</p>
<p><b>geo_region:</b>        {geo_region}</p>
<p><b>geo_region_name:</b>		 {geo_region_name}</p>
<p><b>geo_city:</b>				      {geo_city}</p>
<p><b>geo_zip:</b>				       {geo_zip}</p>
<p><b>geo_latitude:</b>			   {geo_latitude}</p>
<p><b>geo_longitude:</b>		   {geo_longitude}</p>
<p><b>geo_metro_code:</b>		  {geo_metro_code}</p>
<p><b>geo_area_code:</b>		   {geo_area_code}</p>
<p><b>geo_continent_code:</b>{geo_continent_code}</p>
