                                                                                                                               
                                  #######                                                                                          
                                  #     # #    # ###### #####  #    # # ###### #    #                                              
                                  #     # #    # #      #    # #    # # #      #    #                                              
                                  #     # #    # #####  #    # #    # # #####  #    #                                              
                                  #     # #    # #      #####  #    # # #      # ## #                                              
                                  #     #  #  #  #      #   #   #  #  # #      ##  ##                                              
                                  #######   ##   ###### #    #   ##   # ###### #    #                                              
                                                                                                                                   
                                                                                                                  
┌──────────────────────┐       ┌──────────────────────┐       ┌──────────────────────┐     ┌───────────────────────────────┐       
│                      │       │                      │       │                      │     │                               │       
│ Authenticated Moodle │       │    Report Plugin     │       │   Angular Web App    │     │      Web Service Plugin       │       
│         User         │       │(analytics_dashboard) │       │    (moodle-chart)    │     │(course_statistics_webservice) │       
│                      │       │                      │       │                      │     │                               │       
└──────────────────────┘       └──────────────────────┘       └──────────────────────┘     └───────────────────────────────┘       
            │                              │                              │                                │                       
            │                              │                              │                                │                       
            │                              │                              │                                │                       
            │                              │                              │                                │                       
            │       Request Analytics      │                              │                                │                       
            │───────────Dashboard─────────▶│                              │                                │                       
            │                              │                              │                                │                       
            │                              │────┐Generate OTP Token using │                                │                       
            │                              │    │User ID and timestamp and│                                │                       
            │                              │◀───┘embed in HTML            │                                │                       
            │       Dashboard HTML         │                              │                                │                       
            │◀─────────returned────────────│                              │                                │                       
            │                              │                              │                                │                       
            │                              │                              │                                │                       
            │                              │                              │                                │                       
            │      Load Angular Web App    │                              │                                │                       
            │ ─ ─ ─ ─ from Firebase ─ ─ ─ ─│─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─▶│                                │                       
            │                              │                              │                                │                       
            │                              │                              │          Using OTP from        │                       
            │                              │                              │──────────Report Plugin ───────▶│                       
            │                              │                              │        request user stats      │                       
            │                              │                              │                                │────┐                  
            │                              │                              │                                │    │Queries Moodle DB etc
            │                              │                              │                                │◀───┘                  
            │                              │                              │         Return user            │                       
            │                              │                              │◀─────analytics data in──────── │                       
            │                              │                              │            JSON                │                       
            │                              │                              │                                │                       
            │ ◀────────────────────────────┼──────Render charts───────────│                                │                       
            │                              │                              │                                │                       
            │                              │                              │                                │                       
            │                              │                              │                                │                       
            │                              │                              │                                │                       
                