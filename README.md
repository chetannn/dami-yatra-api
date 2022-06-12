# TODOS

## List of all the APIs for Dami Yatra

### Common

* [x] User Login
* [x] Register a new user (as vendor or customer)
* [x] User Logout
* [x] Email Verification
* [x] Password Reset
* [x] Get User Profile API (need to revisit once)
* [x] Update User Profile API

### Vendor
* [x] Advertisement create API
* [x] View list of all created advertisements (keep on improving it)
* [x] Update an advertisement
* [x] Delete an advertisement
* [] Schedule an advertisement (this is optional if we have time then we will implement)
* [] Vendor can message Customer for a specific advertisement
* [] Vendor can view all of their notifications
* [] Send an email notification to vendor 5 days before the expiry date
* [] Vendor can renew their advertisement before the advertisement expires
* [] Analytics API for all the advertisement

### Customer
* [] List of all advertisements
* [] View single advertisement
* [] Advertisement View Tracking API
* [] Add an advertisement to saved list API
* [] List all the saved advertisement API
* [] Customer can message vendor for a specific advertisement
* [] Customer can view all of their notifications
* [] Add Review to vendor after tour has successfully completed API
* [] Customer Payment Process (this is a whole single module)


### Pricing Model

* [?] Vendor can feature their advertisement (for 1 month, 3 months, 6 months, 12 months)
* [?] What is the cost for per advertisement ? (need to clarify this with Ayush and Nabaraj)
* [?] Is the cost will be same for all the pricing months ? (need to clarify this with Ayush and Nabaraj)
* [?] Run a job at the end of each month (this should be after the completion of ad i guess) to calculate total amount of money earned by all vendor in the system
* [?] Run a job to set `ad_expired_at` on the 4th day (at midnight) before the advertisement expires
* [?] Send email notification to vendor 5 days before the expiry date


### Note: Search will be our main focus after all the implementing these apis will be look over it
