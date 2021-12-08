<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div class="content-wrap" style="display: block;Margin:0 auto;margin:0 auto;background-color: #323232;width:600px;">
            <div class="content" style="padding: 10px; background-color: #ffffff;text-align: center;font-size: 18px;color: #323232;padding: 20px 30px;">
                <div class="logo" style="margin:50px auto;Margin:50px auto;">
                    <h1>Fuse</h1>
                </div>
                <div class="text-div" style="margin: 50px auto;Margin:50px auto;">
                    <h1><span style="color:#0099cb;text-transform: uppercase;Margin-left:10px;margin-left:10px;">{{''}}</span></h1>
                    <h3 style="margin: 30px auto;Margin:30px auto;">You have got an Invitation from {{$data['email']}}</h3>
                </div>
                <a href="{{URL::to('http://localhost:4200/#/apps/scrumboard/boards/tabular')}}/{{$data['tab_id']}}" style="background-color: #66cc9a;border:3px solid #63c694;display: inline-block;padding: 10px 40px;box-shadow: 1px 3px 5px #63c694;text-decoration: none;cursor: pointer;color: white;margin: 30px auto;Margin:30px auto;">Accept</a>
            </div>
            <div class="footer" style="color:white;padding: 20px 30px;text-align: center;">
                <p></p>
            </div>
        </div>
    </body>
</html>

