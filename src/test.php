<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Demo - Toast Plugin</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/jquery.toast.css">
    <style type="text/css">
        * {
            font-family: 'Roboto Slab', serif;
            margin: 0;
            padding: 0;
        }

        hr {
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }

        h1, h2 {
            margin: 20px 0px 10px;
        }

        a {
            text-decoration: none;
        }

        .container {
            display: block;
            width: 1200px;
            margin: auto;
        }

        strong {
            padding-bottom: 1px;
            border-bottom: 1px dotted;
        }

        p {
            margin: 10px 0px;
        }

        code {
            font-family: monospace;
            color: #2d2d2d;
            background: whitesmoke;
            display: block;
            padding: 10px;
            border: 1px solid #ccc;
            overflow: scroll;
        }

        a.eval-js {
            color: whitesmoke;
            padding: 5px 10px;
            display: inline-block;
            margin-bottom: 10px;
            background: #2d2d2d;
            border-radius: 2px;
        }

        span.muted {
            font-size: 17px;
            color: #8B7373;
        }

        span.code {
            font-family: monospace;
            color: #2d2d2d;
            background: whitesmoke;
            padding: 5px;
            border: 1px solid #ccc;
        }

        div.code-runner {
            margin: 20px 20px;
        }

        ul, ol {
            margin: 10px 50px;
        }

        ul li {
            margin-bottom: 10px;
        }

        .hidden {
            display: none;
        }

        span.k {
            display: inline-block;
            width: 175px;
        }

        span.c {
            color: #F7BCBC;
            padding-left: 30px;
        }

        .plugin-options label {
            display: inline-block;
            width: 265px;
        }

        span.toast-position span.k {
            display: inline;
        }

        .toast-index .muted {
            display: block;
            color: #AD9D9D;
        }

        .toast-index .muted:hover {
            color: #333;
        }

        .latest-update {
            padding: 0px 30px;
            border: 1px dashed;
            margin: 30px 0;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 style="text-align: center; margin: 20px 0px;">Jquery Toast Plugin</h1>
    <hr>

    <h1>Index</h1>
    <ul class="toast-index">
        <li><a href="#quick-demos">Quick Demos</a> <span class="muted">Some quick demos and the code to generate that, if you are in a hurry!</span>
        </li>
        <li><a href="#toast-generator">Generator</a> <span class="muted">A generator for you to <strong>easily generate the code for the kind of toast you want</strong>, so that <strong>you don't have to go through the documentation!</strong></span>
        </li>
        <li>
            <a href="#options">Options</a> <span class="muted">Each of the options is accompanied by a demo explaining that option.</span>
            <ul>
                <li><a href="#toast-head">Specifying the heading</a></li>
                <li><a href="#sticky-toast">Making them sticky</a></li>
                <li><a href="#toast-timer">Changing the toast hide timer</a></li>
                <li><a href="#showhide-animation">Changing the show/hide animation</a></li>
                <li><a href="#closeable-toasts">Making the toast closeable or not</a></li>
                <li><a href="#toasts-stack">Setting the toast stack</a></li>
                <li><a href="#toasts-positioning">Positioning the toast</a></li>
                <li><a href="#toasts-icons">Messages with icons</a></li>
                <li><a href="#toasts-bg-color">Background &amp; text color</a></li>
                <li><a href="#toasts-text-alignment">Setting the text alignment</a></li>
                <li><a href="#toasts-events">Toast Events</a></li>
                <li><a href="#updating-toasts">Updating Toasts</a></li>
                <li><a href="#resetting-toasts">Resetting Toasts</a></li>
            </ul>
        </li>
    </ul>

    <div class="latest-update">
        <h1 id="latest-update">Latest Update</h1>
        <p>Toast loader has been introduced in the latest version. Check the demo below to see it in action</p>
        <div class="code-runner" style="margin-left: 0px; margin-right: 0px;">
            <a class="eval-js" href="#">Run code</a>
            <pre><code>$.toast('Here you can put the text of the toast')</code></pre>
        </div>

        <p>Loader is enabled by default. In order to disable it or change the color, use the `loader` and `loaderBg`
           options. Have a look at the demo below</p>

        <div class="code-runner" style="margin-left: 0px; margin-right: 0px;">
            <a class="eval-js" href="#">Run code</a>
            <pre><code>$.toast({
    heading: 'Information',
    text: 'Loaders are enabled by default. Use `loader`, `loaderBg` to change the default behavior',
    icon: 'info',
    loader: true,        // Change it to false to disable loader
    loaderBg: '#9EC600'  // To change the background
})</code></pre>
        </div>
    </div>


    <h1 id="quick-demos">Quick Demos</h1>

    <p>To generate a <strong>most simple toast</strong>, all you have to do is</p>
    <div class="code-runner">
        <a class="eval-js" href="#">Run code</a>
        <pre><code>$.toast('Here you can put the text of the toast')</code></pre>
    </div>

    <p>There are different kinds of toast types:</p>
    <div class="code-runner">
        <a class="eval-js" href="#">Run code</a>
        <pre><code>$.toast({
    heading: 'Information',
    text: 'Now you can add icons to generate different kinds of toasts',
    showHideTransition: 'slide',
    icon: 'info'
})</code></pre>
    </div>

    <div class="code-runner">
        <a class="eval-js" href="#">Run code</a>
        <pre><code>$.toast({
    heading: 'Error',
    text: 'Report any &lt;a href="https://github.com/kamranahmedse/jquery-toast-plugin/issues"&gt;issues&lt;/a&gt;',
    showHideTransition: 'fade',
    icon: 'error'
})</code></pre>
    </div>

    <div class="code-runner">
        <a class="eval-js" href="#">Run code</a>
        <pre><code>$.toast({
    heading: 'Warning',
    text: 'It is going to be supper easy for you to use ;)',
    showHideTransition: 'plain',
    icon: 'warning'
})</code></pre>
    </div>

    <div class="code-runner">
        <a class="eval-js" href="#">Run code</a>
        <pre><code>$.toast({
    heading: 'Success',
    text: 'And these were just the basic demos! Scroll down to check further details on how to customize the output.',
    showHideTransition: 'slide',
    icon: 'success'
})</code></pre>
    </div>

    <h1 id="options">Options</h1>
    <p>Of course that is not all what you can do using this plugin, there are a lot of other options. Let's start
       explaining each, one by one</p>
    <p>You should note that, whenever you are going to use options, you have to pass an <span
                class="code">options</span> object and specify the text as follows:</p>

    <div class="code-runner">
        <a href="#" class="eval-js">Run code</a>
        <pre><code>$.toast({
    text: 'This will become the toast message'
})</code></pre>
    </div>

    <p>The text can be an array:</p>

    <div class="code-runner">
        <a href="#" class="eval-js">Run code</a>
        <pre><code>$.toast({
    heading: 'How to contribute?!',
    text: [
        'Fork the repository',
        'Improve/extend the functionality',
        'Create a pull request'
    ],
    icon: 'info'
})</code></pre>
    </div>

    <p>Or put some HTML in the text</p>

    <div class="code-runner">
        <a href="#" class="eval-js">Run code</a>
        <pre><code>$.toast({
    heading: 'Can I add &lt;em&gt;icons&lt;/em&gt;?',
    text: 'Yes! check this &lt;a href="https://github.com/kamranahmedse/jquery-toast-plugin/commits/master"&gt;update&lt;/a&gt;.',
    hideAfter: false,
    icon: 'success'
})</code></pre>
    </div>

    <h2 id="toast-head"><span class="muted">1.</span> Specifying the heading of toast message</h2>
    <p>You can use the heading to set the <span class="code">heading</span> property to set the heading of the toast
       message</p>
    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code>$.toast({
    heading: 'Headings',
    text: 'You can use the `heading` property to specify the heading of the toast message.',
})</code></pre>
    </div>

    <h2 id="sticky-toast"><span class="muted">2.</span> Making them sticky:</h2>
    <p>There will be times, when you will want to have <strong>sticky toasts</strong>. To make them
        <strong>sticky</strong>, all you have to do is set the <span class="code">hideAfter</span> to <span
                class="code">false</span>. Here is a sticky toast</p>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code>$.toast({
    text: 'Set the `hideAfter` property to false and the toast will become sticky.',
    hideAfter: false
})</code></pre>
    </div>

    <p><sup>*</sup> <span class="code">hideAfter</span> property is basically used to set the timer after which the
                                                        toast will get hidden. But you can set it to false in order to
                                                        achieve the sticky toasts.</p>

    <h2 id="toast-timer"><span class="muted">3.</span> Changing the toast hide timer</h2>
    <p>You can use the property from the above option i.e. <span class="code">hideAfter</span> to change the timer after
       which toast gets hidden. You have to specify the timer in milliseconds</p>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code>$.toast({
    text: 'Set the `hideAfter` property to milliseconds and the toast will hide after the specified milli seconds.',
    hideAfter: 5000   // in milli seconds
})</code></pre>
    </div>

    <h2 id="showhide-animation"><span class="muted">4.</span> Changing the show/hide animation</h2>
    <p>You can use <span class="code">showHideTransition</span> property to set the animation. Following are the
       available options:</p>
    <ul>
        <li><span class="code">fade</span> for fade transitions</li>
        <li><span class="code">slide</span> for slide up and down transitions</li>
        <li><span class="code">plain</span> simple show from and hide to corner transition</li>
    </ul>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code>$.toast({
    text: 'Set the `showHideTransition` property to fade|plain|slide to achieve different transitions',
    heading: 'Slide transition',
    showHideTransition: 'slide'
})</code></pre>
    </div>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code>$.toast({
    text: 'Set the `showHideTransition` property to fade|plain|slide to achieve different transitions',
    heading: 'Fade transition',
    showHideTransition: 'fade'
})</code></pre>
    </div>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code>$.toast({
    text: 'Set the `showHideTransition` property to fade|plain|slide to achieve different transitions',
    heading: 'Plain transition',
    showHideTransition: 'plain'
})</code></pre>
    </div>

    <h2 id="closeable-toasts"><span class="muted">5.</span> Making the toast closeable or not</h2>
    <p>You can use <span class="code">allowToastClose</span> to allow the user to close the toast or not. The only thing
       that this option does is make that little cross button show or hide itself</p>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code>$.toast({
    heading: 'Closeable Toast',
    text: 'Set the `allowToastClose` property to true|false to make the toast closeable or not',
    allowToastClose: true
})</code></pre>
    </div>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code>$.toast({
    heading: 'Non closeable Toast',
    text: 'Set the `allowToastClose` property to true|false to make the toast closeable or not',
    allowToastClose: false
})</code></pre>
    </div>

    <h2 id="toasts-stack"><span class="muted">6.</span> Setting the toast stack</h2>
    <p><span class="code">stack</span> property can be used to specify how many maximum toasts you want to show at any
                                       point of time. By default this property is set to 5</p>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code>$.toast({
    heading: 'Stack',
    text: 'If set to a number, it will show that number of toasts at max at a time',
    stack: 4
})</code></pre>
    </div>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code>$.toast({
    heading: 'No stacking',
    text: 'If set to false, there will be only one toast at once.',
    stack: false
})</code></pre>
    </div>

    <p><strong>Note</strong> Hit the run button multiple times to test these demos.</p>

    <h2 id="toasts-positioning"><span class="muted">7.</span> Positioning the toast</h2>
    <p><span class="code">position</span> property can be used to specify the position. There are following predefined
                                          positions which you can use:</p>
    <ul>
        <li><span class="code">bottom-left</span> value to show the toast at bottom left position</li>
        <li><span class="code">bottom-right</span> value to show the toast at bottom right position</li>
        <li><span class="code">bottom-center</span> value to..</li>
        <li><span class="code">top-right</span> value to..</li>
        <li><span class="code">top-left</span> value to..</li>
        <li><span class="code">top-center</span> value to..</li>
        <li><span class="code">mid-center</span> value to..</li>
        <li><span class="code">{ top: '-', bottom: '-', left: '-', right: '-' }</span> javascript object with
                                                                                       positioning properties as you set
                                                                                       in CSS
        </li>
    </ul>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code><span class='hidden'>$.toast().reset('all');</span>$.toast({
    heading: 'Positioning',
    text: 'Specify the custom position object or use one of the predefined ones',
    position: 'bottom-left',
    stack: false
})</code></pre>
    </div>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code><span class='hidden'>$.toast().reset('all');</span>$.toast({
    heading: 'Positioning',
    text: 'Specify the custom position object or use one of the predefined ones',
    position: 'bottom-right',
    stack: false
})</code></pre>
    </div>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code><span class='hidden'>$.toast().reset('all');</span>$.toast({
    heading: 'Positioning',
    text: 'Use the predefined ones, or specify a custom object',
    position: 'bottom-center',
    stack: false
})</code></pre>
    </div>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code><span class='hidden'>$.toast().reset('all');</span>$.toast({
    heading: 'Positioning',
    text: 'Use the predefined ones, or specify a custom object',
    position: 'top-left',
    stack: false
})</code></pre>
    </div>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code><span class='hidden'>$.toast().reset('all');</span>$.toast({
    heading: 'Positioning',
    text: 'Use the predefined ones, or specify a custom position object.',
    position: 'top-right',
    stack: false
})</code></pre>
    </div>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code><span class='hidden'>$.toast().reset('all');</span>$.toast({
    heading: 'Positioning',
    text: 'Use the predefined ones, or specify a custom position object.',
    position: 'top-center',
    stack: false
})</code></pre>
    </div>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code><span class='hidden'>$.toast().reset('all');</span>$.toast({
    heading: 'Positioning',
    text: 'Use the predefined ones, or specify a custom position object.',
    position: 'mid-center',
    stack: false
})</code></pre>
    </div>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code><span class='hidden'>$.toast().reset('all');</span>$.toast({
    heading: 'Positioning',
    text: 'Use the predefined ones, or specify a custom position object.',
    position: {
        left: 120,
        top: 120
    },
    stack: false
})</code></pre>
    </div>

    <p><strong>Note</strong> It should be noted that, once you change the position of toast by using the `position`
                             property, you'll have to reset the position for the next toasts, if you want them to appear
                             at their default position i.e. the bottom left corner. Or else, each new toast generated
                             will be appearing at the last position i.e. where you displayed the last positioned toast.
                             You can reset the toast position by.</p>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code>$.toast().reset('all');</code></pre>
    </div>

    <h2 id="toasts-icons"><span class="muted">8.</span> Messages with icons</h2>
    <p><span class="code">icon</span> property can be used to specify the predefined types of toasts. Following are the
                                      predefined types:</p>
    <ul>
        <li><span class="code">info</span> generates a toast with information icon</li>
        <li><span class="code">warning</span> generates a toast with warning icon</li>
        <li><span class="code">error</span> generates a toast with error icon</li>
        <li><span class="code">success</span> generates a toast with success icon</li>
    </ul>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code>$.toast({
    heading: 'Warning',
    text: 'Now you can seemlessly generate warnings using the icon property in the options',
    icon: 'warning'
})</code></pre>
    </div>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code>$.toast({
    heading: 'Success',
    text: 'Here is some kind of success message with a success icon that you can notice at the left side.',
    icon: 'success'
})</code></pre>
    </div>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code>$.toast({
    heading: 'Error',
    text: 'An unexpected error occured while trying to show you the toast! ..Just kidding, it is just a message, toast is right in front of you.',
    icon: 'error'
})</code></pre>
    </div>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code>$.toast({
    heading: 'Information',
    text: 'Now you can add icons to the toasts as well.',
    icon: 'info'
})</code></pre>
    </div>

    <h2 id="toasts-bg-color"><span class="muted">9.</span> Background &amp; text color</h2>
    <p><span class="code">bgColor</span> property is used to specify the background color of the toast message. Default
                                         is '#444'</p>
    <p><span class="code">textColor</span> property is used to specify the text color of the toast message. Default is
                                           '#eee'</p>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code>$.toast({
    heading: 'Colors',
    text: 'Colors are specified using `bgColor` and `textColor` properties.',
    bgColor: '#FF1356',
    textColor: 'white'
})</code></pre>
    </div>

    <h2 id="toasts-text-alignment"><span class="muted">10.</span> Setting the text alignment</h2>
    <p><span class="code">textAlign</span> property is used to set the alignment of text inside the toast. Permitted
                                           values are:</p>
    <ul>
        <li><span class="code">left</span></li>
        <li><span class="code">right</span></li>
        <li><span class="code">center</span></li>
    </ul>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code>$.toast({
    text: 'Processing! Please wait..',
    textAlign: 'center'
})</code></pre>
    </div>

    <h2 id="toasts-class"><span class="muted">9.</span> Custom Classes </h2>
    <p><span class="code">class</span> property is used to add custom classes to the toast element</p>
    <style type="text/css">
        .larger-font {
            font-size: larger;
        }
    </style>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code>$.toast({
    heading: 'Custom Classes',
    text: 'Custom classes are specified using the `class` option.',
    class: 'larger-font'
})</code></pre>
    </div>

    <h2 id="toasts-events"><span class="muted">11.</span> Toast Events</h2>
    <p>Toast exposes the following events for you to bind to whatever you want</p>
    <ul>
        <li><span class="code">beforeShow</span> will be triggered right before the toast is about to appear</li>
        <li><span class="code">afterShown</span> will be triggered after the toast has appeared</li>
        <li><span class="code">beforeHide</span> will be triggered before the toast is about to hide</li>
        <li><span class="code">afterHidden</span> will be triggered right after the toast gets hidden</li>
    </ul>

    <div class="code-runner">
        <a href="#" class="eval-js"><span class='hidden'>$.toast().reset('all');</span>Run Code</a>
        <pre><code>$.toast({
    text: 'Triggers the events',

    beforeShow: function () {
        alert('The toast is about to appear');
    },

    afterShown: function () {
        alert('Toast has appeared.');
    },

    beforeHide: function () {
        alert('Toast is about to hide.');
    },

    afterHidden: function () {
        alert('Toast has been hidden.');
    }
})</code></pre>
    </div>

    <h2 id="updating-toasts"><span class="muted">12.</span> Updating Toasts</h2>
    <p>If you have a reference to a toast and want to update that, you can do so by calling the <span class="code">update</span>
       method on the instance.</p>

    <div class="code-runner">
        <a href="#" class="eval-js">Run Code</a>
        <pre><code>
var myToast = $.toast({
    heading: 'Information',
    text: 'Here is some information that will be later on turned to an error',
    icon: 'info',
    hideAfter: false
});

// Update the toast after three seconds.
window.setTimeout(function(){
    myToast.update({
        heading: 'Error',
        text: 'Here is an information that changed to error',
        icon: 'error',
        hideAfter: false
    });
}, 3000)

</code></pre>
    </div>

    <h2 id="resetting-toasts"><span class="muted">13.</span> Resetting Toasts</h2>
    <p>If you have the reference to a specific toast, you can reset that by doing the following</p>

    <div class="code-runner">
<pre><code>
var myToast = $.toast('Some toast that needs to be removed.');
myToast.reset(); // remove the toast "Some toast that needs to be removed"
</code></pre>
    </div>

    <p>If you do not have the reference to a specific toast and want to reset every toast, do the following:</p>
    <div class="code-runner">
<pre><code>
$.toast().reset('all');
</code></pre>
    </div>


    <div class="plugin-options">
        <h1 id="toast-generator">Customize Plugin</h1>

        <p>
            <label for="toast-text">Text</label> <input type="text" id="toast-text" class="toast-text"
                                                        value="Don't forget to star the repository if you like it.">
        </p>
        <p>
            <label for="toast-heading">Heading</label>
            <input type="text" id="toast-heading" class="toast-heading" value="Note">
        </p>
        <p>
            <label for="toast-transition">Transition</label>
            <select name="toast-transition" id="toast-transition" class="toast-transition">
                <option value="fade">Fade</option>
                <option value="slide">Slide</option>
                <option value="plain">Plain</option>
            </select>
        </p>
        <p>
            <label for="allow-toast-close">Allow Toast Close</label>
            <select name="allow-toast-close" id="allow-toast-close" class="allow-toast-close">
                <option value="true">True</option>
                <option value="false">False</option>
            </select>
        </p>

        <p>
            <label for="auto-hide-toast">Auto Hide</label>
            <select name="auto-hide-toast" id="auto-hide-toast" class="auto-hide-toast">
                <option value="true">True</option>
                <option value="false">False</option>
            </select>
        </p>

        <p class="autohide-after sub-item">
            <label for="autohide-after">Hide (with transition^) after (ms)</label>
            <input type="text" id="autohide-after" class="autohide-after" value="3000">
        </p>

        <p class="">
            <label for="stack-toasts">Stack toasts</label>
            <select name="stack-toasts" id="stack-toasts" class="stack-toasts">
                <option value="true">Yes</option>
                <option value="false">No</option>
            </select>
        </p>

        <p class="stack-length sub-item">
            <label for="stack-length">Stack Length </label>
            <input type="text" id="stack-length" class="stack-length" value="5">
        </p>

        <p class="">
            <label for="toast-position">Toast Position</label>
            <select name="toast-position" id="toast-position" class="toast-position">
                <option value="bottom-left">Bottom Left</option>
                <option value="bottom-right">Bottom Right</option>
                <option value="top-left">Top Left</option>
                <option value="top-right">Top Right</option>
                <option value="top-center">Top Center</option>
                <option value="bottom-center">Bottom Center</option>
                <option value="mid-center">Mid Center</option>
                <option value="custom-position">Custom</option>
            </select>
        </p>

        <div class="custom-toast-position sub-item" style="display:none;">
            <label for="custom-toast-position">Custom Toast Position</label>
            <ul>
                <li>
                    <label for="left-position">Left</label> <input type="text" class="left-position" id="left-position">
                </li>
                <li>
                    <label for="right-position">Right</label>
                    <input type="text" class="right-position" id="right-position">
                </li>
                <li>
                    <label for="top-position">Top</label> <input type="text" class="top-position" id="top-position">
                </li>
                <li>
                    <label for="bottom-position">Bottom</label>
                    <input type="text" class="bottom-position" id="bottom-position">
                </li>
            </ul>
        </div>

        <p class="">
            <label for="text-align">Icon</label> <select name="icon-type" id="icon-type" class="text-align">
                <option value="">-- No icon --</option>
                <option selected="selected" value="warning">Warning</option>
                <option value="success">Success</option>
                <option value="error">Error</option>
                <option value="info">Information</option>
            </select>
        </p>

        <div class="custom-color-info" style="display: none;">
            <p>
                <label for="toast-bg">Background Color</label>
                <input type="color" id="toast-bg" class="toast-bg" value="#444444">
            </p>

            <p>
                <label for="toast-text-color">Text Color</label>
                <input type="color" id="toast-text-color" class="toast-text-color" value="#eeeeee">
            </p>
        </div>

        <p class="">
            <label for="text-align">Text Alignment</label> <select name="text-align" id="text-align" class="text-align">
                <option value="left">Left</option>
                <option value="right">Right</option>
                <option value="center">Center</option>
            </select>
        </p>

        <p class="">
            <label for="add-toast-events">Toast Events</label>
            <select name="add-toast-events" id="add-toast-events" class="add-toast-events">
                <option value="true">True</option>
                <option value="false">False</option>
            </select>
        </p>

        <p class="">
            <label for="show-loader">Show Loader</label>
            <select name="show-loader" id="show-loader" class="show-loader">
                <option value="true">True</option>
                <option value="false">False</option>
            </select>
        </p>
        <p>
            <label for="loader-bg">Loader Color</label>
            <input type="color" id="loader-bg" class="loader-bg" value="#9EC600">
        </p>


        <div class="code-runner">
            <a href="#" class="btn generate-toast eval-js">Generate</a>
            <pre style="padding:0px; background: #f0f3f3;"><code style="margin:0px;" class="highlight">
<span class="nd">$</span>.<span class="nf">toast</span>({
    <span class="toast-text-line"><span class="k">text</span>: "<span class="toast-text s">Hey there fellas, here is a simple toast. Change the options above and then see the code that generates that toast</span>", <span
                class="c">// Text that is to be shown in the toast</span></span>
    <span class="toast-heading-line"><span class="k">heading</span>: '<span class="toast-heading s">How to use</span>', <span
                class="c">// Optional heading to be shown on the toast</span></span>
    <span class="toast-icon-line"><span class="k">icon</span>: '<span class="toast-icon s">warning</span>', <span
                class="c">// Type of toast icon</span></span>
    <span class="toast-transition-line"><span class="k">showHideTransition</span>: '<span class="toast-transition s">fade</span>', <span
                class="c">// fade, slide or plain</span></span>
    <span class="toast-allowToastClose-line"><span class="k">allowToastClose</span>: <spna
                class="kt toast-allowToastClose">true</spna>, <span class="c">// Boolean value <span
                    class="kt">true</span> or <span class="kt">false</span></span></span>
    <span class="toast-hideAfter-line"><span class="k">hideAfter</span>: <span
                class="n toast-hideAfter">3000</span>, <span class="c">// <span class="kt">false</span> to make it sticky or number representing the miliseconds as time after which toast needs to be hidden</span></span>
    <span class="toast-stackLength-line"><span class="k">stack</span>: <span class="n toast-stackLength">5</span>, <span
                class="c">// <span class="kt">false</span> if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time</span></span>
    <span class="toast-position-string-line"><span class="k">position</span>: '<span class="s toast-position">bottom-left</span>', <span
                class="c">// bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values</span></span>
    <span class="toast-position-string-obj"><span class="k">position</span>: <span class="s toast-position">{ <span
                    class="k">left</span> : <span class="n toast-position-left">20</span>, <span class="k">right</span> : <span
                    class="n toast-position-right">20</span>, <span class="k">top</span> : <span
                    class="n toast-position-top">20</span>, <span class="k">bottom</span> : <span
                    class="n toast-position-bottom">20</span> }</span>, <span class="c">// bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values</span></span>
    <span class="toast-bgColor-line" style="display: none;"><span class="k">bgColor</span>: '<span
                class="s toast-bgColor">#444</span>', <span class="c"> // Background color of the toast</span></span>
    <span class="toast-textColor-line" style="display: none;"><span class="k">textColor</span>: '<span
                class="s toast-textColor">#eee</span>', <span class="c"> // Text color of the toast</span></span>
    <span class="toast-textAlign-line"><span class="k">textAlign</span>: '<span class="s toast-textAlign">left</span>', <span
                class="c"> // Text alignment i.e. left, right or center</span></span>
    <span class="toast-loader-line"><span class="k">loader</span>: <span class="s toast-textLoader">true</span>, <span
                class="c"> // Whether to show loader or not. True by default</span></span>
    <span class="toast-loaderBg-line"><span class="k">loaderBg</span>: '<span
                class="s toast-textLoaderBg">#9EC600</span>', <span
                class="c"> // Background color of the toast loader</span></span>
    <span class="toast-beforeShow-line"><span class="nb k">beforeShow</span>: <span class="nf toast-beforeShow">function ()</span> {}, <span
                class="c">// will be triggered before the toast is shown</span></span>
    <span class="toast-afterShown-line"><span class="nb k">afterShown</span>: <span class="nf toast-afterShown">function ()</span> {}, <span
                class="c">// will be triggered after the toat has been shown</span></span>
    <span class="toast-beforeHide-line"><span class="nb k">beforeHide</span>: <span class="nf toast-beforeHide">function ()</span> {}, <span
                class="c">// will be triggered before the toast gets hidden</span></span>
    <span class="toast-afterHidden-line"><span class="nb k">afterHidden</span>: <span class="nf toast-afterHidden">function ()</span> {} <span
                class="c"> // will be triggered after the toast has been hidden</span></span>
});
              </code></pre>

        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.toast.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {

                $('.eval-js').on('click', function (e) {
                    e.preventDefault();

                    if (!$(this).hasClass('generate-toast')) {
                        var code = $(this).siblings('pre').find('code').text();
                        code.replace("<span class='hidden'>", '');
                        code.replace("</span");

                        eval(code);
                    }

                });

                $('#icon-type').on('change', function () {
                    if (!$(this).val()) {
                        $('.custom-color-info').show();
                        $('.toast-icon-line').hide();
                        $('.toast-bgColor-line').show();
                        $('.toast-textColor-line').show();
                    } else {
                        $('.toast-icon-line').show();
                        $('.custom-color-info').hide();
                        $('.toast-bgColor-line').hide();
                        $('.toast-textColor-line').hide();
                        $('.toast-icon-line span.toast-icon').text($(this).val());
                    }
                });

                // You are about to see some extremely horrible code that can be MUCH MUCH improved,
                // I've knowlingly done it that way, please don't judge me based upon this ;)
                $(document).ready(function () {

                    function generateCode() {
                        var text = $('.plugin-options #toast-text').val();
                        var heading = $('.plugin-options #toast-heading').val();
                        var transition = $('.toast-transition').val();
                        var allowToastClose = $('#allow-toast-close').val();
                        var autoHide = $('#auto-hide-toast').val();
                        var stackToasts = $('#stack-toasts').val();
                        var toastPosition = $('#toast-position').val()
                        var toastBg = $('#toast-bg').val();
                        var toastTextColor = $('#toast-text-color').val();
                        var toastIcon = $('#icon-type').val();
                        var textAlign = $('#text-align').val();
                        var toastEvents = $('#add-toast-events').val();
                        var loader = $('#show-loader').val();
                        var loaderBg = $('#loader-bg').val();

                        if (text) {
                            $('.toast-text-line').show();
                            $('.toast-text-line .toast-text').text(text);
                        } else {
                            $('.toast-text-line').hide()
                            $('.toast-text-line .toast-text').text('');
                        }


                        if (heading) {
                            $('.toast-heading-line').show();
                            $('.toast-heading-line .toast-heading').text(heading);
                        } else {
                            $('.toast-heading-line').hide()
                            $('.toast-heading-line .toast-heading').text('');
                        }


                        if (transition) {
                            $('.toast-transition-line').show()
                            $('.toast-transition-line .toast-transition').text(transition);
                        } else {
                            $('.toast-transition-line').hide();
                            $('.toast-transition-line .toast-transition').text('fade');
                        }

                        if (allowToastClose) {
                            $('.toast-allowToastClose-line').show();
                            $('.toast-allowToastClose-line .toast-allowToastClose').text(allowToastClose);
                        } else {
                            $('.toast-allowToastClose-line').hide();
                            $('.toast-allowToastClose-line .toast-allowToastClose').text(false);
                        }

                        if (autoHide && (autoHide == 'false')) {
                            $('.toast-hideAfter-line').show();
                            $('.toast-hideAfter-line .toast-hideAfter').text('false');
                            $('.autohide-after').hide();
                        } else {
                            $('.toast-hideAfter-line').show();
                            $('.toast-hideAfter-line .toast-hideAfter').text($('#autohide-after').val() ? $('#autohide-after').val() : 3000);
                            $('.autohide-after').show();
                        }

                        if (stackToasts && stackToasts != 'true') {
                            $('.toast-stackLength-line').show();
                            $('.toast-stackLength-line .toast-stackLength').text(stackToasts);
                            $('.stack-length').hide();
                        } else {
                            $('.stack-length').show();
                            $('.toast-stackLength-line').show();
                            $('.toast-stackLength-line .toast-stackLength').text($('#stack-length').val() ? $('#stack-length').val() : 5);
                        }

                        if (toastPosition && (toastPosition !== 'custom-position')) {
                            $('.toast-position-string-line').show();
                            $('.custom-toast-position').hide();
                            $('.toast-position-string-line .toast-position').text(toastPosition);
                        } else {
                            $('.toast-position-string-line').hide();
                            $('.toast-position-string-line .toast-position').text('');
                        }

                        if (toastPosition && (toastPosition === 'custom-position')) {
                            $('.custom-toast-position').show();
                            $('.toast-position-string-obj').show();
                            var left = $('#left-position').val() ? $('#left-position').val() : 'auto';
                            var right = $('#right-position').val() ? $('#right-position').val() : 'auto';
                            var top = $('#top-position').val() ? $('#top-position').val() : 'auto';
                            var bottom = $('#bottom-position').val() ? $('#bottom-position').val() : 'auto';
                            $('.toast-position-string-obj .toast-position-left').text((left !== 'auto') ? left : "'" + left + "'");
                            $('.toast-position-string-obj .toast-position-right').text((right !== 'auto') ? right : "'" + right + "'");
                            $('.toast-position-string-obj .toast-position-top').text((top !== 'auto') ? top : "'" + top + "'");
                            $('.toast-position-string-obj .toast-position-bottom').text((bottom !== 'auto') ? bottom : "'" + bottom + "'");
                        } else {
                            $('.toast-position-string-obj').hide();
                            // $('.toast-position-string-obj toast-position').text('');
                        }

                        if (!toastIcon) {
                            if (toastBg) {
                                $('.toast-bgColor-line').show();
                                $('.toast-bgColor-line .toast-bgColor').text(toastBg);
                            } else {
                                $('.toast-bgColor-line').hide();
                                $('.toast-bgColor-line .toast-bgColor').text('');
                            }

                            if (toastTextColor) {
                                $('.toast-textColor-line').show();
                                $('.toast-textColor-line .toast-textColor').text(toastTextColor);
                            } else {
                                $('.toast-textColor-line').hide();
                                $('.toast-textColor-line .toast-textColor').text('');
                            }
                        }

                        if (textAlign) {
                            $('.toast-textAlign-line').show();
                            $('.toast-textAlign-line .toast-textAlign').text(textAlign);
                        } else {
                            $('.toast-textAlign-line').hide();
                            $('.toast-textAlign-line .toast-textAlign').text('');
                        }

                        if (loader == 'false') {
                            $('.toast-textLoader').html('false');
                        } else {
                            $('.toast-textLoader').html('true');
                        }

                        if (loaderBg) {
                            $('.toast-textLoaderBg').html(loaderBg);
                        }

                        if (toastEvents == 'false') {
                            $('.toast-beforeShow-line').hide();
                            $('.toast-afterShown-line').hide();
                            $('.toast-beforeHide-line').hide();
                            $('.toast-afterHidden-line').hide();
                        } else {
                            $('.toast-beforeShow-line').show();
                            $('.toast-afterShown-line').show();
                            $('.toast-beforeHide-line').show();
                            $('.toast-afterHidden-line').show();
                        }
                    }

                    $('#top-position').on('change', function () {
                        $('#bottom-position').val('auto');
                    });
                    $('#bottom-position').on('change', function () {
                        $('#top-position').val('auto');
                    });
                    $('#left-position').on('change', function () {
                        $('#right-position').val('auto');
                    });
                    $('#right-position').on('change', function () {
                        $('#left-position').val('auto');
                    });
                    $('.plugin-options :input').on('change', function () {
                        $.toast().reset('all');
                        generateCode();
                    });

                    $('.generate-toast').on('click', function (e) {
                        e.preventDefault();
                        generateToast();
                    });

                    function generateToast() {
                        var options = {};

                        if ($('.toast-text-line').is(':visible')) {
                            options.text = $('.toast-text-line .toast-text').text();
                        }

                        if ($('.toast-heading-line').is(':visible')) {
                            options.heading = $('.toast-heading').text();
                        }


                        if ($('.toast-transition-line').is(':visible')) {
                            options.showHideTransition = $('.toast-transition-line .toast-transition').text();
                        }


                        if ($('.toast-allowToastClose-line').is(':visible')) {
                            options.allowToastClose = ($('.toast-allowToastClose-line .toast-allowToastClose').text() === 'true');
                        }


                        if ($('.toast-hideAfter-line').is(':visible')) {
                            options.hideAfter = parseInt($('.toast-hideAfter-line .toast-hideAfter').text(), 10) || false;
                        }


                        if ($('.toast-stackLength-line').is(':visible')) {
                            options.stack = parseInt($('.toast-stackLength-line .toast-stackLength').text(), 10) || false;
                        }


                        if ($('.toast-position-string-line').is(':visible')) {
                            options.position = $('.toast-position-string-line .toast-position').text();
                        }


                        if ($('.toast-position-string-obj').is(':visible')) {
                            options.position = {};
                            options.position.left = parseFloat($('.toast-position .toast-position-left').text()) || 'auto';
                            options.position.right = parseFloat($('.toast-position .toast-position-right').text()) || 'auto';
                            options.position.top = parseFloat($('.toast-position .toast-position-top').text()) || 'auto';
                            options.position.bottom = parseFloat($('.toast-position .toast-position-bottom').text()) || 'auto';
                        }


                        if ($('.toast-icon-line').is(':visible')) {
                            options.icon = $('.toast-icon-line .toast-icon').text();
                        }


                        if ($('.toast-bgColor-line').is(':visible')) {
                            options.bgColor = $('#toast-bg').val();
                        }


                        if ($('.toast-text-color').is(':visible')) {
                            options.textColor = $('#toast-text-color').val();
                        }


                        if ($("#text-align").is(':visible')) {
                            options.textAlign = $('#text-align').val();
                        }


                        options.loader = $('.toast-textLoader').html() !== 'false';
                        options.loaderBg = $('.toast-textLoaderBg').html();

                        $.toast(options);
                    }

                    generateCode();
                });
            });
        </script>
</body>
</html>
<?php
/*
echo "<ol>";
foreach ($_SERVER as $k => $v)
    echo "<li>'" . $k . "' = " . $v . "</li>";
echo "</ol>";*/
?>