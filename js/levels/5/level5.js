var whichAntiMissileBattery = function( x ) {

  if( antiMissileBatteries[0].hasMissile() === false) {
    if( antiMissileBatteries[0].hasMissile() === false) {
      if( antiMissileBatteries[0].hasMissile() === false) {
        return -1;
      }
    }
  }


  if( x <= CANVAS_WIDTH / 3 )
  {
    return firedToOuterThird( 0, 1, 2 );
  } 
  else if( x >= CANVAS_WIDTH / 3)
  {
    if (x <= 2*(CANVAS_WIDTH / 3) ) 
    {

      if ( antiMissileBatteries[1].hasMissile() )
      {
        return 1;
      } 
      else {
        
        if ( x <= CANVAS_WIDTH / 2 ) 
        { Editor
￼
( x <= CANVAS_WIDTH / 2 ) 
        { 
          retu
1
var whichAntiMissileBattery = function( x ) {
2
​
3
  if( antiMissileBatteries[0].hasMissile() === false) {
4
    if( antiMissileBatteries[0].hasMissile() === false) {
5
      if( antiMissileBatteries[0].hasMissile() === false) {
6
        return -1;
7
      }
8
    }
9
  }
10
​
11
​
12
  if( x <= CANVAS_WIDTH / 3 )
13
  {
14
    return firedToOuterThird( 0, 1, 2 );
15
  } 
16
  else if( x >= CANVAS_WIDTH / 3)
17
  {
18
    if (x <= 2*(CANVAS_WIDTH / 3) ) 
19
    {
20
​
21
      if ( antiMissileBatteries[1].hasMissile() )
22
      {
23
        return 1;
24
      } 
25
      else {
26
        
27
        if ( x <= CANVAS_WIDTH / 2 ) 
28
        { 
29
          return firedtoMiddleThird( 0, 2 );
30
        }
31
        else if (x > CANVAS_WIDTH / 2)
32
        {
33
          return firedtoMiddleThird( 2, 0 );
34
        }
35
      } 
36
    }
37
    else if (x > 2*(CANVAS_WIDTH / 3))
38
    {
39
      return firedToOuterThird( 2, 1, 0 );
40
    }
41
  }
42
};
￼Execute ￼Evaluate ￼Restart Game
Made by Gianluca Monica an
          return firedtoMiddleThird( 0, 2 );
        }
        else if (x > CANVAS_WIDTH / 2)
        {
          return firedtoMiddleThird( 2, 0 );
        }
      } 
    }
    else if (x > 2*(CANVAS_WIDTH / 3))
    {
      return firedToOuterThird( 2, 1, 0 );
    }
  }
};