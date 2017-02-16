function startDoc(){
  var intro = introJs();
  //DOCUMENTATION LEVEL1
  var stringlev0 = "<h3></h3>";
  var stringlev1 = " Apparently my code isn't <em>good enough</em> anymore. Whatever, no hard feelings. I can help you with some programming "+
                    "and Javascript theory, and info about the system. Don't worry, my indications are up-to-date now. The afterlife is very, well, infinite. And boring."+
                    " Gives you a lot of time to study... Here are some tips:" +
                    "<ol> <li> JavaScript <b>variables</b> (ex. <code>speed</code>) are containers for storing data values. This data can be "+
                    "numbers, text (strings) or even <b>functions</b>.</li>"                
  var stringlev1a = "<li>A JavaScript <b>function</b> is a block of code designed to perform a particular task,"+
                    "it takes input (ex. <code>xDistance</code>, <code>yDistance</code>) and returns output/s. </li>";
  var stringlev1b = "<li>You can assign a value to a variable using the <b>=</b> operator.</li>"
  var stringlev1c= "<li><code>Math.sqrt(num)</code> and <code>Math.pow(base, exponent)</code> calculate respectively the square root of the input and the base to the exponent power.</li>"
  var stringlev1d = "<li>The <code>return</code> statement ends function execution and specifies a value to be returned by the function.</li></ol>"
  //DOCUMENTATION LEVEL2
  var stringlev2 = "<h3>Here are some  tips: </h3> "+
                    "<ol> <li>JavaScript <b>arrays</b> are used to store multiple values in a single variable. You can access the values by "+
                    "referring to an index number (ex. <code>array[0]</code> refers to the first element of the array).";
  var stringlev2a = "<li>The easiest way to add a new element to an array is using the <code>push</code> method.</li>";
  var stringlev2b = "<li>In this case, <code>playerMissiles</code> is an array containing our missiles to be shot. "+
                    "<code>playerMissiles.push( ... )</code> adds a new element to this array.</li>"
  var stringlev2c= "<li><code>PlayerMissile</code> is a Javascript <b>object</b>. Objects are a collection of <b>properties</b> (which are name:value associations, just like variables) and <b>methods</b> (functions which describe actions you can perform on objects)."+
                    "For now what you need to know is that each object has a <b>constructor</b>, a function which creates and initializes the properties of an object.</li>"+
                    "<li>The <code>new</code> operator is used to create an instance of an object. To create an object, the <code>new</code> operator is followed by the constructor method. </li>"+
                    "<li>In this case, the <code>PlayerMissile(source, x, y)</code> constructor takes in input a missile's origin and x and y coordinates of the target. "+
                    "</li></ol>"
  //DOCUMENTATION LEVEL3
  var stringlev3 = "<h3>Here some tips: </h3> <ol><li>The <b>for</b> loop can be used to execute a block of code a number of times. It has the following syntax: <br>"+
                    "<code>for (stat 1; stat 2; stat 3) { <br>  &emsp; code block to be executed <br> } </code><br>" +
                    "<b>Stat 1</b> is the statement executed before the loop starts, <b>stat 2</b> defines the condition for running the loop and <b>stat 3</b> is executed "+
                    "each time after the loop has been executed.</li>"
  var stringlev3a = "<li> In this case, the variable <code>i</code> " +
                    "is set to 0 before executing the loop for the first time and is incremented by one each time the loops is executed (<code>++</code> operator). "+
                    "The loop will be executed until the statement <code>i < 5</code> is true, so it will stop executing once <code>i</code> reaches 5. " +
                    "With these parameters, this loop will execute 5 times. </li>";
  //DOCUMENTATION LEVEL4
  var stringlev4 = "<h3>Here some tips: </h3> <ol> <li>I already explained <b>arrays</b> are used to store multiple values in a single variable.</li>";
  var stringlev4b = "<li>You can access to the elements of an array using index numbers. Array indexing starts at 0.</li>";
  var stringlev4a = "<li>In this case, the <code>antiMissileBatteries</code> array contains <code>AntiMissileBattery</code> objects, which "+
                    "have a <code>missilesLeft</code> property, indicating the missiles they have left. You can access object properties using "+
                    "dot notation (<code>object.property</code>).</li>"
  var stringlev4c= "<li>Remember the for loop's syntax: <br></li>"+
                    "<code>for (stat 1; stat 2; stat 3) { <br>  &emsp; code block to be executed <br> } </code><br>" + "</ol>";
 //DOCUMENTATION LEVEL5
  var stringlev5 = "<h3>Here are some tips: </h3> <ol>" + 
                  "<li><b>Recursion</b> is a programming concept. The textbook definition of recursion is calling a function on itself. It is used when we are doing the same thing over and over again to a particular value until we get the desired result.</li>";
  var stringlev5a = "<li> There are a few key features of recursion that must be included in order for it to work properly. The first is a <b>base case</b>: this is a statement, usually within a conditional clause like if, that stops the recursion. If you don't have a base case, the recursion will go on infinitely and your program will crash. Crash = bad. The second is a <b>recursive case</b>: this is the statement where the recursion actually happens: where the recursive function is called on itself.</li>";
  var stringlev5b = "<li> When building your recursive case (the code that will be repeated), one of the rules of thumb is to ensure that the arguments you use for the recursion will lead to your base case. If the value we pass to the recursive function call is the same as the initial value, chances are our code will enter an infinite loop. And then, crash. Bad. So, the question you have to ask yourself is 'does the recursive case modify my arguments in such a way that each recursion brings it one step closer to the base case?'</li>";
//DOCUMENTATION LEVEL6
  var stringlev6 = "<h3>Here are some tips for you: </h3> <ol> <li>Remember, you can access to an array's element using indexes ( ex. <code>array[0]</code>)</li>";
  var stringlev6a = "<li> Very often when you write code, you want to perform different actions for different decisions. You can use conditional statements in your code to do this. The <code>if</code> statement is used to specify a block of code to be executed, if a specified condition is true. It's syntax is the following: <br><code>if (condition){<br> &nbsp;block of code to be executed if the condition is true <br>}</code>";
  var stringlev6b = "<li> The condition can be expressed using comparison and logical operators (which test for true or false).<li>&nbsp;<code><</code>,<code><=</code>,<code>></code>,<code>>=</code> are used for less than, less or equal than, greater than, greater or equal than comparisons.</li>" +
                    "<li>&nbsp;<code>&&</code>,<code>||</code>,<code>!</code> are used respectively for the logical operations AND, OR and NOT.</li></ol>";
//DOCUMENTATION LEVEL7
  var stringlev7 = "<h3>You already know how to do this!</h3> <ul><li>Remember, you can access an object's property using dot notation.</li></ul>";
//DOCUMENTATION LEVEL8
  var stringlev8 = "<h3>Here are some tips:</h3><ol>"+
                    "<li><b>Shields</b> are objects. Their constructor <code>Shield(x,y)</code> takes in input the coordinates of their position (<code>x</code> and <code>y</code>). The keyword <code>new</code> creates a new instance of an object." +
                    "<li>Remember, you can add elements to an array using the <code>push</code> method.</li></ol>";
//DOCUMENTATION LEVEL9
  var stringlev9 = "<h3>Here are some tips:</h3><ol>"+
                    "<li>Javascript <b>strings</b> can store a series of characters. A string can be any text inside quotes. You can use single or double quotes.</li>"+
                    "<li>Just like arrays, you can access to specific characters of the string using indexes. String indexes are zero-based: the first character is in position 0, the second in 1, and so on." +
                    "<li>You can find the length of a string by accessing the property <code>length</code> ( ex. <code>var stringLength = string.length</code>). Remember, the indexes begin at 0, so the index of the <b>last</b> element of a string has the index <b>string.length - 1 </b>.</li>" +
                    "<li>The + operator can also be used to add (concatenate) strings. For example: <br> <code>&nbsp; <br>var newString = 'Hell' + 'o'</code>&nbsp; <br> newString now contains the string 'Hello'.</li></ol>";
 
  switch(level){
      case 1:
      {
            intro.setOptions({
                  steps: [
                //   {
                //       intro: "This is the documentation. It will help you sooo much! "
                // },
                {
                      element: document.querySelector('#editorpanel'),
                      intro: "<img src='img/ghost.png' class='image-general center-block'/> <br>" + "Well hello there! I am the ghost of the lead developer who passed away a long time ago..." + stringlev0 + stringlev1 + stringlev1a + stringlev1b + stringlev1c + stringlev1d,
                      position: 'right'
                },
                 
      
      ]
});

            break;
      }
      case 2:
      {

intro.setOptions({
      steps: [
      

      {
                      element: document.querySelector('#editorpanel'),
                      intro: "<img src='img/ghost.png' class='image-general center-block'/> <br>" + stringlev2 + stringlev2a + stringlev2b + stringlev2c,
                      position: 'right'
                }


      ]
    });








            break;
      }
      case 3:
      {
            intro.setOptions({
      steps: [
      

      {
                      element: document.querySelector('#editorpanel'),
                      intro:"<img src='img/ghost.png' class='image-general center-block'/> <br>" + stringlev3 + stringlev3a,
                      position: 'right'
                }


      ]
    });



            break;
      }
      case 4:
      {

            intro.setOptions({
      steps: [
      

      {
                      element: document.querySelector('#editorpanel'),
                      intro:"<img src='img/ghost.png' class='image-general center-block'/> <br>" + stringlev4 + stringlev4a + stringlev4b + stringlev4c,
                      position: 'right'
                }


      ]
    });
            break;
      }
      case 5:
      {

            intro.setOptions({
      steps: [
      

      {
        element: document.querySelector('#editorpanel'),
        intro:"<img src='img/ghost.png' class='image-general center-block'/> <br>" + stringlev5 + stringlev5a + stringlev5b,
        position: 'right'
      }


      ]
    });

            break;
      }
      case 6:
      {

            intro.setOptions({
      steps: [
      

      {
                      element: document.querySelector('#editorpanel'),
                      intro: "<img src='img/ghost.png' class='image-general center-block'/> <br>" +stringlev6 + stringlev6a + stringlev6b,
                      position: 'right'
                }


      ]
    });
            break;
      }
      case 7:
      {

            intro.setOptions({
      steps: [
      

      {
                      element: document.querySelector('#editorpanel'),
                      intro:"<img src='img/ghost.png' class='image-general center-block'/> <br>" + stringlev7  ,
                      position: 'right'
                }


      ]
    });
            break;
      }
      case 8:
      {
       
            intro.setOptions({
      steps: [
      

      {
                      element: document.querySelector('#editorpanel'),
                      intro:"<img src='img/ghost.png' class='image-general center-block'/> <br>" + stringlev8  ,
                      position: 'right'
                }


      ]
    });
            break;
      }
      case 9:
      {
       
            intro.setOptions({
      steps: [
      

      {
                      element: document.querySelector('#editorpanel'),
                      intro:"<img src='img/ghost.png' class='image-general center-block'/> <br>" + stringlev9 ,
                      position: 'right'
                }


      ]
    });
            break;
      }
}

































intro.start();
}
