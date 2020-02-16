Laravel Project

1)Install composer: composer install  

2)Serve your Laravel: php artisan serve

3)Create sql database test_db

4)Import sql file from here=> database/migrations/test_db.sql

5)Config application environment variables .env file 
  DB_DATABASE=test_db
  DB_USERNAME=yourUsername
  DB_PASSWORD=yourPassword
  

Url Examples:
http://127.0.0.1:8000/api/v1?mmsi[]=311040700&mmsi[]=247039300&minLat=34.82611&maxLat=34.82611&minLon=31.43108&maxLon=31.43108&minTstamp=1372700640&maxTstamp=1372700640&type=application/json

http://127.0.0.1:8000/api/v1?mmsi311040700&minLat=34.82611&maxLat=34.82611&minLon=31.43108&maxLon=31.43108&minTstamp=1372700640&maxTstamp=1372700640&type=application/json   

http://127.0.0.1:8000/api/v1?mmsi311040700&minLat=34.82611&maxLat=34.82611&minLon=31.43108&maxLon=31.43108&minTstamp=1372700640&maxTstamp=1372700640&type=text/csv  

Log file  ../storage/logs/api.log

































API_V1_LOGFILE =>storage/logs/api.log# vesselTracking
