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
        { 
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