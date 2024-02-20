<?php

$config = 

    [

        'contactus_validation' => [

            [

                'field' => 'name',

                'label' => 'Name',

                'rules' => 'trim|required|alpha_numeric_spaces|xss_clean'

            ],

            [

                'field' => 'email',

                'label' => 'Email',

                'rules' => 'trim|required|valid_email'

            ],

            [

                'field' => 'phone',

                'label' => 'Contact',

                'rules' => 'trim|required|is_numeric'

            ],

            [

                'field' => 'subject',

                'label' => 'Subject',

                'rules' => 'trim|required|xss_clean'

            ],

            [

                'field' => 'message',

                'label' => 'Message',

                'rules' => 'required|xss_clean'

            ]

        ],

        'searchbox_validation' => [

            [

                'field' => 'search',

                'label' => 'Search',

                'rules' => 'trim|required|xss_clean|htmlspecialchars'

            ]

        ],
        //PRODUCT DESCRIPTION
        'get_quote_validation' => [

            [
                'field' => 'name',
                'rules' => 'trim|required|alpha_numeric_spaces|xss_clean'
            ],

            [
                'field' => 'email',
                'rules' => 'trim|required|valid_email'
            ],

            // [
            //     'field' => 'subject',
            //     'rules' => 'trim|required|xss_clean'
            // ],

            [
                'field' => 'product',
                'rules' => 'trim|required|xss_clean'
            ],

            [
                'field' => 'message',
                'rules' => 'trim|required|xss_clean'
            ]
           

        ],

        'ask_an_enquiry_validation' => [

            [

               'field' => 'name',

               'label' => 'Name',

               'rules' => 'trim|required|alpha_numeric_spaces|xss_clean'

           ],

           [

               'field' => 'email',

               'label' => 'Email',

               'rules' => 'trim|required|valid_email'

           ],

           // [

           //     'field' => 'phone',

           //     'label' => 'Phone number',

           //     'rules' => 'trim|required|is_numeric'

           // ],

           [

               'field' => 'product_name',

               'label' => 'Product name',

               'rules' => 'trim|required|xss_clean'

           ],

           [

               'field' => 'subject',

               'label' => 'subject',

               'rules' => 'trim|required|xss_clean'

           ]

           // [

           //     'field' => 'url',

           //     'label' => 'URL',

           //     'rules' => 'trim|required|valid_url'

           // ],

           // [

           //     'field' => 'location',

           //     'label' => 'Location',

           //     'rules' => 'trim'

           // ]

          

       ],

     'enquiry_validation' => [

            [

                'field' => 'qq_name',

               
                'rules' => 'trim|required|alpha_numeric_spaces|xss_clean'

            ],

            [

                'field' => 'qq_email',

               
                'rules' => 'trim|required|valid_email'

            ],
            [
 
                'field' => 'qq_subject',
 
                
 
                'rules' => 'trim|required|xss_clean'
 
            ],

            [

                'field' => 'qq_product',
 
                
                'rules' => 'trim|required|xss_clean'
 
            ],
 
            

            [

                'field' => 'qq_message',

                'rules' => 'trim|required|xss_clean'

            ],

            

        ],

        'user_register_validation' => [

            [

                'field' => 'company_person',

                'label' => 'Contact Person',

                'rules' => 'trim|required|alpha_numeric_spaces|xss_clean'

            ],

            [

                'field' => 'company_name',

                'label' => 'Company Name',

                'rules' => 'trim|required|alpha_numeric_spaces|xss_clean'

            ],

            // [

            //     'field' => 'username',

            //     'label' => 'User Name',

            //     'rules' => 'trim|required|alpha_numeric_spaces|xss_clean'

            // ],

            [

                'field' => 'email',

                'label' => 'Email Address',

                'rules' => 'trim|required|valid_email|is_unique[distributors.email]',

                'errors'=> [

                            'is_unique' => 'The email you entered is already registered. Please enter a different email address.'

                           ]

            ],

            [

                'field' => 'password',

                'label' => 'Password',

                'rules' => 'trim|required|min_length[8]'

            ],

            [

                'field' => 'cpassword',

                'label' => 'Password Confirmation',

                'rules' => 'trim|required|min_length[8]|matches[password]'

            ],

            [

                'field' => 'phone',

                'label' => 'Phone',

                'rules' => 'trim|required|is_numeric'

            ],

            [

                'field' => 'location',

                'label' => 'Country',

                'rules' => 'trim|required|alpha_numeric_spaces|xss_clean'

            ],

            [

                'field' => 'address',

                'label' => 'Address',

                'rules' => 'trim|required|xss_clean'

            ]

           

        ],

        'login_validation' => [

            [

                'field' => 'email',

                'label' => 'Email Address',

                'rules' => 'trim|required|valid_email'

            ],

            [

                'field' => 'password',

                'label' => 'Password',

                'rules' => 'trim|required'

            ]

        ],

        'forgot_pwd_validation' => [

            [

                'field' => 'email',

                'label' => 'Email Address',

                'rules' => 'trim|required|valid_email'

            ]

        ],

        'change_pwd_validation' => [

            [

                'field' => 'oldpassword',

                'label' => 'Current Password',

                'rules' => 'trim|required'

            ],

            [

                'field' => 'password',

                'label' => 'New Password',

                'rules' => 'trim|required|min_length[8]|differs[oldpassword]',

                'errors'=> [

                            'differs'=>'New Password cannot be same as Current Password'

                           ]

            ],

            [

                'field' => 'cpassword',

                'label' => 'New Password Confirmation',

                'rules' => 'trim|required|min_length[8]|matches[password]'

            ]

        ],

        'reset_pwd_validation' => [

            [

                'field' => 'password',

                'label' => 'New Password',

                'rules' => 'trim|required|min_length[8]'

            ],

            [

                'field' => 'cpassword',

                'label' => 'New Password Confirmation',

                'rules' => 'trim|required|min_length[8]|matches[password]'

            ]

        ],

        'cart_validation' => [

            [

                'field' => 'email',

                'label' => 'Email Address',

                'rules' => 'trim|required|valid_email'

            ]

        ],

        'edit_profile_validation' => [

            [

                'field' => 'company_person',

                'label' => 'Contact Person',

                'rules' => 'trim|required|alpha_numeric_spaces|xss_clean'

            ],

            [

                'field' => 'company_name',

                'label' => 'Company Name',

                'rules' => 'trim|required|alpha_numeric_spaces|xss_clean'

            ],

            // [

            //     'field' => 'username',

            //     'label' => 'User Name',

            //     'rules' => 'trim|required|alpha_numeric_spaces|xss_clean'

            // ],

            [

                'field' => 'email',

                'label' => 'Email Address',

                'rules' => 'trim|required|valid_email',

            ],

            [

                'field' => 'phone',

                'label' => 'Phone',

                'rules' => 'trim|required|is_numeric'

            ],

            [

                'field' => 'location',

                'label' => 'Country',

                'rules' => 'trim|required|alpha_numeric_spaces|xss_clean'

            ],

            [

                'field' => 'address',

                'label' => 'Address',

                'rules' => 'trim|required|xss_clean'

            ]

        ],

        'career_validation' => [

            [

                'field' => 'name',

                'label' => 'First Name',

                'rules' => 'trim|required|alpha_numeric_spaces|xss_clean'

            ],

            [

                'field' => 'surname',

                'label' => 'LastName',

                'rules' => 'trim|required|alpha_numeric_spaces|xss_clean'

            ],

            [

                'field' => 'email',

                'label' => 'Email',

                'rules' => 'trim|required|valid_email',

            ],

            [

                'field' => 'phone',

                'label' => 'Phone',

                'rules' => 'trim|required|is_numeric'

            ],

            [

                'field' => 'address',

                'label' => 'Address',

                'rules' => 'trim|required|xss_clean'

            ],

            [

                'field' => 'state',

                'label' => 'State/zip',

                'rules' => 'trim|required|xss_clean'

            ],

            [

                'field' => 'country',

                'label' => 'Country',

                'rules' => 'trim|required|xss_clean'

            ],

            [

                'field' => 'qualification',

                'label' => 'Higher Education',

                'rules' => 'trim|required|xss_clean'

            ],

            [

                'field' => 'position',

                'label' => 'Position',

                'rules' => 'trim|required|xss_clean'

            ]

            // [

            //     'field' => 'myfile',

            //     'label' => 'Upload CV',

            //     'rules' => 'trim|required|xss_clean'

            // ]

           

        ]

    ];

?>