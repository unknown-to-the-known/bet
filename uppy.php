<!doctype html>
<html lang="en">
  <head>
    <title></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://releases.transloadit.com/uppy/v3.20.0/uppy.min.css" rel="stylesheet"/>
  </head>
  <body>
    <noscript>You need JavaScript enabled for this example to work.</noscript>
    <button id="uppyModalOpener">Open Modal</button>

    <script type="module">
      import {
        Uppy,
        Dashboard,       
        Audio,
        AwsS3,
      } from 'https://releases.transloadit.com/uppy/v3.20.0/uppy.min.mjs'

      const uppy = new Uppy({ debug: true, autoProceed: false })
        .use(Dashboard, { trigger: '#uppyModalOpener' })        
        .use(Audio, { target: Dashboard }) 
        .use(AwsS3, {
              shouldUseMultipart: (file) => file.size > 100 * 2 ** 20,
              companionUrl: 'https://companion.uppy.io',
          });
        
        uppy.on('success', (fileCount) => {
        console.log(`${fileCount} files uploaded`)
      })
    </script>

    <!-- To support older browsers, you can use the legacy bundle which adds a global `Uppy` object.  -->
    <script nomodule src="https://releases.transloadit.com/uppy/v3.20.0/uppy.legacy.min.js"></script>
    <script nomodule>
      {
        const { Dashboard, Webcam, Tus } = Uppy
        const uppy = new Uppy.Uppy({ debug: true, autoProceed: false })
        .use(Dashboard, { trigger: '#uppyModalOpener'})          
        uppy.on('success', function (fileCount) {
          console.log(`${fileCount} files uploaded`)
        })
      }
    </script>
  </body>
</html>