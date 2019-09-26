<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Four Peaks</title>
        
        <link rel="stylesheet" href="http://fourpeaksrealestate.com.au/themes/four-peaks/assets/css/app.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

        <style type="text/css">
            #main-header {
                height: auto;
            }

            #main-header .grid-container {
                height: auto;;
            }

            section {
                background-color: #fff;
                padding-top: 16px;
            }
        </style>
    </head>

    <body>
        <header id="main-header" class="black">
            <div class="grid-container">
                <div class="grid-x">
                    <div class="cell small-12 text-center" style="position: relative">
                        <a href="http://fourpeaksrealestate.com.au">
                            <img data-interchange="[ http://fourpeaksrealestate.com.au/themes/four-peaks/assets/img/logo-black-small.png, small], [ http://fourpeaksrealestate.com.au/themes/four-peaks/assets/img/logo-black-small.png, medium], [ http://fourpeaksrealestate.com.au/themes/four-peaks/assets/img/logo-black-large.png, large]">
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <section>
            <div class="grid-container">
                <div class="grid-x">
                    <div class="cell small-12">
                        <h3>The Four Peaks Real Estate website database have been updated</h3>

                        <hr>

                        <p class="lead">{{ $num_records }} listing(s) were found</p>

                        <hr>

                        @if (count($updated_arr) > 0)
                            <ul>
                                @foreach($updated_arr as $listing)
                                    <li>{{ $listing }} is synchronised with the Rex data</li>
                                @endforeach
                            </ul>
                            
                            <hr>
                        @else
                            <ul>
                                <li>All listing(s) are synchronised with the Rex data</li>
                            </ul>
                            
                            <hr>
                        @endif
                        
                        @if (count($removed_arr) > 0)
                            <ul>
                                @foreach($removed_arr as $listing)
                                    <li>{{ $listing }} was removed from the database</li>
                                @endforeach
                            </ul>
                        @else
                            <ul>
                                <li>There are no sold listing(s) since the last update</li>
                            </ul>
                            
                            <hr>
                        @endif

                        @if (count($added_arr) > 0)
                            <ul>
                                @foreach($added_arr as $listing)
                                    <li>{{ $listing }} was added to the database</li>
                                @endforeach
                            </ul>
                        @else
                            <ul>
                                <li>There are no new listing(s) since the last update</li>
                            </ul>
                            
                            <hr>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <pre>
            <?php print_r($dump); ?>
        </pre>

        <script src="http://fourpeaksrealestate.com.au/themes/four-peaks/assets/js/vendor/jquery.js"></script>
        <script src="http://fourpeaksrealestate.com.au/themes/four-peaks/assets/js/vendor/what-input.js"></script>
        <script src="http://fourpeaksrealestate.com.au/themes/four-peaks/assets/js/vendor/foundation.js"></script>
        <script src="http://fourpeaksrealestate.com.au/themes/four-peaks/assets/js/app.js"></script>
    </body>
</html>