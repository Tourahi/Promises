
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>BOOO</h1>
  </body>
  <script type="text/javascript">

    function loadscript(src , callback)
    {
      let script = document.createElement('script');
      script.src = src;

      //Now load
      script.onload  = () => callback(null , script);
      script.onerror = () => callback
                            (new Error("The script did not load.")
                            , script);
      document.head.append(script);
    }


    let callback  = (error , script) => {
      if (error){
        console.log(error);
      }
      else{
        console.log("script loaded");

        console.log(script);
      }
    }

    loadscript('./test.js' ,callback);

    //Now we want to promisify te call : loadscript('./test.js' ,callback)

    function promisify(f) {
      return function (...args) { // return a wrapper-function

        return new Promise((resolve, reject) => {

          function callback(err, result) { // our custom callback for f
            if (err) {
              reject(err);
            } else {
              resolve(result);
            }
          }

          args.push(callback); // append our custom callback to the end of f arguments

          f.call(this, ...args); // call the original function
        });
      };
    };

    let loadScriptPromise = promisify(loadscript);

    loadScriptPromise('./test.js')
    .then(respounse => {
      console.log('From the promise');
      console.log(respounse);
    });
  </script>
</html>
