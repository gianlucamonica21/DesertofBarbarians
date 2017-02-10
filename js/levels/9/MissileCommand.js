// Missile Command

var canvas = document.querySelector( 'canvas' ),
ctx = canvas.getContext( '2d' );

// Constants
var CANVAS_WIDTH  = canvas.width,
CANVAS_HEIGHT = canvas.height,
MISSILE = {
  active: 1,
  exploding: 2,
  imploding: 3,
  exploded: 4
};

// Variables
var levelscore = 0,
level = 9,
maxLevel = 1,
levelIndex = {},
cities = [],
antiMissileBatteries = [],
playerMissiles = [],
enemyMissiles = [],
bonusMissileDestroyed,
timerID;

var scoreArray = [1060,925,0,0,0,0,0,0,0,0];
var score = 1985;

var contrAerea;
var undef;

var elementPos = [{x: 35, y:410}, {x: 255, y:410}, {x: 475, y:410},
{x: 80, y:430}, {x: 130, y:430}, {x: 180, y:430}, {x: 300, y:430}, {x: 350, y:430}, {x: 400, y:430} ];
// Create cities and anti missile batteries at the start of the game
var missileCommand = function(checkLevel) {
  cities = [];
  antiMissileBatteries = [];

    // Bottom left position of cities
    createCities();

    // Top middle position of anti-missile batteries
    createAntimissileBattery();

    initializeLevel();

    levelscore = 0;

    setupListeners();
  };

  var createCities = function () {
    cities.push( new City( elementPos[3].x,  elementPos[3].y) );
    cities.push( new City( elementPos[4].x,  elementPos[4].y) );
    cities.push( new City( elementPos[5].x,  elementPos[5].y) );
    cities.push( new City( elementPos[6].x,  elementPos[6].y) );
    cities.push( new City( elementPos[7].x,  elementPos[7].y) );
    cities.push( new City( elementPos[8].x,  elementPos[8].y) );
  }

  var createAntimissileBattery = function () {
    antiMissileBatteries.push( new AntiMissileBattery(  elementPos[0].x,  elementPos[0].y) );
    antiMissileBatteries.push( new AntiMissileBattery(  elementPos[1].x,  elementPos[1].y) );
    antiMissileBatteries.push( new AntiMissileBattery(  elementPos[2].x,  elementPos[2].y) );
  }

  var initializeAntiMissileBatteries = function () {
    $.each( antiMissileBatteries, function( index, amb ) {
      amb.missilesLeft = 0;
    }); 
  };

  var rechargeAntiMissileBatteries = function () {
    for(i=0;i<3;i++){
      antiMissileBatteries[i].missilesLeft = 6;
    }
  };

// Reset various variables at the start of a new level
var initializeLevel = function() {
  initializeAntiMissileBatteries();
  rechargeAntiMissileBatteries();
  playerMissiles = [];
  enemyMissiles = [];
  createEmemyMissiles();
  createBonusMissiles(/*gamelevel.missilesBonus*/0);
  drawBeginLevel();
};

// Create a certain number of enemy missiles based on the game level
var createEmemyMissiles = function() {
  var targets = viableTargets(),
  numMissiles = /*Increased since last level*/ 15;
  for( var i = 0; i < numMissiles; i++ ) {
    enemyMissiles.push( new EnemyMissile(targets) );
  }
};

// Create a certain number of bonus missiles
var createBonusMissiles = function(n) {
  var targets = viableTargets();
  for( var i = 0; i < n; i++ ) {
    enemyMissiles.push( new BonusMissile(targets) );
  }
};

// Get a random number between min and max, inclusive
var rand = function( min, max ) {
  return Math.floor( Math.random() * (max - min + 1) ) + min;
};

// Show various graphics shown on most game screens
var drawGameState = function() {
  drawBackground();
  drawCities();
  drawAntiMissileBatteries();
 //   drawScore();
};

var drawBeginLevel = function() {
  drawGameState();
  drawLevelMessage();
};

// Show current score
var drawScore = function() {
  ctx.fillStyle = 'white';
  ctx.font =  'bold 15px consolas, monaco';
  ctx.fillText( 'level score: ' + levelscore, 15, 40 );
  ctx.fillText( 'total score: ' + score, 15, 25);
  ctx.fillText( 'lvl: ' + level, 15, 55);
  ctx.fillText( 'multiplier: ' + getMultiplier() + 'x', 15, 70 );
};

// Show message before a level begins
var drawLevelMessage = function() {
  ctx.fillStyle = 'white';

  ctx.font =  '25px monaco, consolas';
  ctx.fillText( 'click to start.', 130, 180 );

  ctx.font = 'bold 25px monaco, consolas';
  ctx.fillStyle = 'white';
  ctx.fillText( 'level ' + level, 130, 150 );

  ctx.font = 'bold 32px monaco, consolas';
  ctx.fillStyle = '#26070A';
  ctx.fillText( 'DEFEND THE BASE!', 130, 250 );
};

var drawStopMessage = function() {

  ctx.fillStyle = '#6d6';

  ctx.font =  '20px monaco, consolas';
  ctx.fillText( 'Game is now stop', 130, 180 );
  ctx.font = 'bold 32px monaco, consolas';
  ctx.fillStyle = '#d66';
  ctx.fillText( '', 130, 250 );
  stopLevel();

};

// Show bonus points at end of a level
var drawEndLevel = function( missilesLeft, missilesBonus, citiesSaved, citiesBonus ) {
  drawGameState();
  var bonus = missilesBonus + citiesBonus;
  ctx.fillStyle = '#6d6';
  ctx.font = 'bold 25px monaco, consolas';
 //   ctx.fillText( 'BONUS POINTS: ' +  bonus, 150, 149 );

 ctx.font = '20px monaco, consolas';
 ctx.fillStyle = 'white';
 //   ctx.fillText( '' + missilesBonus, 170, 213 );
 ctx.fillStyle = 'white';
 ctx.fillText( 'Missiles Left: ' + missilesLeft, 230, 213 );
 ctx.fillStyle = 'white';
 //   ctx.fillText( '' + citiesBonus, 170, 277 );
 ctx.fillStyle = 'white';
 ctx.fillText( 'Cities Saved: ' + citiesSaved, 230, 277 );
};

// Draw all active cities
var drawCities = function() {
  $.each( cities, function( index, city ) {
    if( city.active ) {
      city.draw();
    }
  });
};

// Draw missiles in all anti missile batteries
var drawAntiMissileBatteries = function() {
  $.each( antiMissileBatteries, function( index, amb ) {
    amb.draw();
  });
};

// Get the factor by which the score earned in a level will
// be multiplied by (maximum factor of 6)
var getMultiplier = function() {
  return ( level > 10 ) ? 6 : Math.floor( (level + 1) / 2 );
};

// Show the basic game background
var drawBackground = function() {
    // Draw SKY
    var grd=ctx.createLinearGradient(0,0,0,510);
    grd.addColorStop(0,"#163C52");
    grd.addColorStop(0.3,"#4F4F47");
    grd.addColorStop(0.6,"#C5752D");
    grd.addColorStop(1,"#B7490F");
  //  grd.addColorStop(1,"#2F1107");

    ctx.fillStyle = grd;
    ctx.fillRect( 0, 0, CANVAS_WIDTH, CANVAS_HEIGHT );

    // Yellow area at bottom of screen for cities and
    // anti missile batteries

    var grdd=ctx.createLinearGradient(0,340,0,550);
    grdd.addColorStop(0,"tan");
    grdd.addColorStop(1,"orange");

    ctx.fillStyle = grdd;
    ctx.beginPath();
    ctx.moveTo( 0, 460 );
    ctx.lineTo( 0,  430 );
    ctx.lineTo( 25, 410 );
    ctx.lineTo( 45, 410 );
    ctx.lineTo( 70, 430 );
    ctx.lineTo( 220, 430 );
    ctx.lineTo( 245, 410 );
    ctx.lineTo( 265, 410 );
    ctx.lineTo( 290, 430 );
    ctx.lineTo( 440, 430 );
    ctx.lineTo( 465, 410 );
    ctx.lineTo( 485, 410 );
    ctx.lineTo( 510, 430 );
    ctx.lineTo( 510, 460 );
    ctx.closePath();
    ctx.fill();
    //sand dunes shadows
    ctx.fillStyle = '#fdce7e';
    ctx.beginPath();
    ctx.lineTo( 0, 430 );
    ctx.lineTo( 25, 410 );
    ctx.lineTo( 35, 410 );
    ctx.lineTo( 60, 435);
    ctx.lineTo( 55, 440);

    ctx.lineTo( 0 ,440);
    ctx.closePath();
    ctx.fill();

    ctx.beginPath();
    ctx.lineTo( 70, 430 );
    ctx.lineTo( 220, 430 );
    ctx.lineTo( 245, 410 );
    ctx.lineTo( 255, 410 );
    ctx.lineTo( 280, 435 );
    ctx.lineTo( 275, 440 );
    ctx.lineTo( 85, 440 );
    ctx.closePath();
    ctx.fill();

    ctx.beginPath();
    ctx.lineTo( 290, 430 );
    ctx.lineTo( 440, 430 );
    ctx.lineTo( 465, 410 );
    ctx.lineTo( 475, 410 );
    ctx.lineTo( 500, 435 );
    ctx.lineTo( 495, 440 );
    ctx.lineTo( 305, 440 );
    ctx.closePath();
    ctx.fill();
  };


// Constructor for a City
function City( x, y ) {
  this.x = x;
  this.y = y;
  this.active = true;
}

// Show a city based on its position
City.prototype.draw = function() {
  var x = this.x,
  y = this.y;

  ctx.fillStyle = '#7e8341';
  ctx.beginPath();
  ctx.moveTo( x, y );
  ctx.lineTo( x, y - 10 );
  ctx.lineTo( x + 10, y - 10 );
  ctx.lineTo( x + 15, y - 15 );
  ctx.lineTo( x + 20, y - 10 );
  ctx.lineTo( x + 30, y - 10 );
  ctx.lineTo( x + 35, y - 5);
  ctx.lineTo( x + 30, y );
  ctx.lineTo( x + 5, y + 5);
  ctx.closePath();
  ctx.fill();

    //city shadows
    ctx.fillStyle = '#4d4729';
    ctx.beginPath();
    x = x+5;
    y = y+5;
    ctx.moveTo( x , y );
    ctx.lineTo( x, y - 10 );
    ctx.lineTo( x + 10, y - 10 );
    ctx.lineTo( x + 15, y - 15 );
    ctx.lineTo( x + 20, y - 10 );
    ctx.lineTo( x + 30, y - 10 );
    ctx.lineTo( x + 30, y );
    ctx.closePath();
    ctx.fill();
  };

// Constructor for an Anti Missile Battery
function AntiMissileBattery( x, y ) {
  this.x = x;
  this.y = y;
  this.missilesLeft = 1;
}

AntiMissileBattery.prototype.hasMissile = function() {
  return !!this.missilesLeft;
};

// Show the missiles left in an anti missile battery
AntiMissileBattery.prototype.draw = function() {
  var x, y;
  var delta = [ [0, 0], [-6, 6], [6, 6], [-12, 12], [0, 12],
  [12, 12], [-18, 18], [-6, 18], [6, 18], [18, 18] ];

  for( var i = 0, len = this.missilesLeft; i < len; i++ ) {
    x = this.x + delta[i][0] + 0;
    y = this.y + delta[i][1] - 10;
      //NEW GRAPHICS
      // Draw a missile-launcher
      ctx.fillStyle = 'black';
      ctx.beginPath();
      ctx.moveTo( x, y );
      ctx.lineTo( x - 3, y + 10);
      ctx.lineTo( x , y + 12);
      ctx.closePath();
      ctx.fill();

      ctx.fillStyle = '#4B5320';
      ctx.beginPath();
      ctx.moveTo(x,y);
      ctx.lineTo( x , y + 12);
      ctx.lineTo( x + 3, y + 10);
      ctx.closePath();
      ctx.fill();
    }
  };

// Constructor for a Missile, which may be the player's missile,
// the enemy's missile or a bonus missile.
// The options argument used to create the missile is expected to
// have startX, startY, endX, and endY to define the missile's path
// as well as color and trailColor for the missile's appearance
function Missile( options ) {
  this.startX = options.startX;
  this.startY = options.startY;
  this.endX = options.endX;
  this.endY = options.endY;
  this.color = options.color;
  this.trailColor = options.trailColor;
  this.x = options.startX;
  this.y = options.startY;
  this.state = MISSILE.active;
  this.width = 2;
  this.height = 2;
  this.explodeRadius = 0;
}

// Draw the path of a missile or an exploding missile
Missile.prototype.draw = function() {
  if( this.state === MISSILE.active ){
    ctx.strokeStyle = this.trailColor;
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.moveTo( this.startX, this.startY );
    ctx.lineTo( this.x, this.y );
    ctx.stroke();

    ctx.fillStyle = this.color;
    ctx.fillRect( this.x - 1, this.y - 1, this.width, this.height );
  } else if( this.state === MISSILE.exploding ||
   this.state === MISSILE.imploding ) {
      //NEW GRAPHICS

      //explosion color
      ctx.fillStyle = this.explodeColor;
      ctx.beginPath();
      ctx.arc( this.x, this.y, this.explodeRadius, 0, 2 * Math.PI );
      ctx.closePath();

      explodeOtherMissiles( this, ctx );

      ctx.fill();
    }
  };



  // Constructor for a Missile, which may be the player's missile or
  // the enemy's missile.
  // The options argument used to create the missile is expected to
  // have startX, startY, endX, and endY to define the missile's path
  // as well as color and trailColor for the missile's appearance
  function Missile( options ) {
    this.startX = options.startX;
    this.startY = options.startY;
    this.endX = options.endX;
    this.endY = options.endY;
    this.color = options.color;
    this.trailColor = options.trailColor;
    this.x = options.startX;
    this.y = options.startY;
    this.state = MISSILE.active;
    this.width = 2;
    this.height = 2;
    this.explodeRadius = 0;
    this.explodeColor = options.explodeColor;
  }

// Handle update to help with animating an explosion
Missile.prototype.explode = function() {
  if( this.state === MISSILE.exploding ) {
    this.explodeRadius++;
  }
  if( this.explodeRadius > 30 ) {
    this.state = MISSILE.imploding;
  }
  if( this.state === MISSILE.imploding ) {
    this.explodeRadius--;
    if( this.groundExplosion ) {
      if ( this instanceof BonusMissile ) {
        this.bonus();
      } else {
        ( this.target[2] instanceof City ) ? this.target[2].active = false : this.target[2].missilesLeft = 0;
      }
    }
  }
  if( this.explodeRadius < 0 ) {
    this.state = MISSILE.exploded;
    if( !this.groundExplosion ) {
      if ( this instanceof BonusMissile ) {
        bonusMissileDestroyed ++;
      }
    }
  }
};

// Calculate the missile speed
// the time with missile reach the point
var missileSpeed = function (xDistance, yDistance) {
  var distance = Math.sqrt( Math.pow(xDistance, 2) + Math.pow(yDistance, 2) );

  var distancePerFrame = 12;

  return distance / distancePerFrame;
};

// Constructor for the Player's Missile, which is a subclass of Missile
// and uses Missile's constructor
function PlayerMissile( source, endX, endY ) {
    // Anti missile battery this missile will be fired from
    var amb = antiMissileBatteries[source];

    Missile.call( this, { startX: amb.x,  startY: amb.y,
      endX: endX,     endY: endY,
      color: 'brown', trailColor: 'rgba(200,50,50,0.5)', explodeColor: 'rgba(255,230,200,0.5)' } );

    var xDistance = this.endX - this.startX,
    yDistance = this.endY - this.startY;
    // Determine a value to be used to scale the orthogonal directions
    // of travel so the missiles travel at a constant speed and in the
    // right direction
    var scale = missileSpeed(xDistance, yDistance);

    this.dx = xDistance / scale;
    this.dy = yDistance / scale;

    amb.missilesLeft--;

    if(amb.missilesLeft === 0){
      amb.missilesLeft = 6;
    }

  }

// Make PlayerMissile inherit from Missile
PlayerMissile.prototype = Object.create( Missile.prototype );
PlayerMissile.prototype.constructor = PlayerMissile;

// Update the location and/or state of this missile of the player
PlayerMissile.prototype.update = function() {
  if( this.state === MISSILE.active && this.y <= this.endY ) {
      // Target reached
      this.x = this.endX;
      this.y = this.endY;
      this.state = MISSILE.exploding;
    }
    if( this.state === MISSILE.active ) {
      this.x += this.dx;
      this.y += this.dy;
    } else {
      this.explode();
    }
  };

// Create a missile that will be shot at indicated location
var playerShoot = function( x, y ) {
  if( y >= 50 && y <= 370 ) {
    var source = whichAntiMissileBattery( x );
      if( source === -1 ){ // No missiles left
        return;
      }
      playerMissiles.push( new PlayerMissile( source, x, y ) );
    }
  };

// Constructor for the Enemy's Missile, which is a subclass of Missile
// and uses Missile's constructor
function EnemyMissile( targets ) {
  var startX = rand( 0, CANVAS_WIDTH ),
  startY = -1,
        // Create some variation in the speed of missiles
        offSpeed = rand(80, 160) / 100,
        // Randomly pick a target for this missile
        target = targets[ rand(0, targets.length - 1) ],
        framesToTarget;

        Missile.call( this, { startX: startX,  startY: startY,
          endX: target[0], endY: target[1],
          color: 'white', trailColor: 'rgba(222,222,222,0.5)', explodeColor: 'rgba(200,100,100,0.5)' } );

        framesToTarget = ( 650 - 30 * /*gamelevel.missilesSpeed*/ 5 ) / offSpeed;
        if( framesToTarget < 20 ) {
          framesToTarget = 20;
        }
        this.dx = ( this.endX - this.startX ) / framesToTarget;
        this.dy = ( this.endY - this.startY ) / framesToTarget;

        this.target = target;
    // Make missiles heading to their target at random times
    this.delay = rand( 0, 50 + level * 20 );
    this.groundExplosion = false;
  }

// Make EnemyMissile inherit from Missile
EnemyMissile.prototype = Object.create( Missile.prototype );
EnemyMissile.prototype.constructor = EnemyMissile;

// Update the location and/or state of an enemy missile.
// The missile doesn't begin it's flight until its delay is past.
EnemyMissile.prototype.update = function() {
  if( this.delay ) {
    this.delay--;
    return;
  }
  if( this.state === MISSILE.active && this.y >= this.endY ) {
      // Missile has hit a ground target (City or Anti Missile Battery)
      this.x = this.endX;
      this.y = this.endY;
      this.state = MISSILE.exploding;
      this.groundExplosion = true;
    }
    if( this.state === MISSILE.active ) {
      this.x += this.dx;
      this.y += this.dy;
    } else {
      this.explode();
    }
  };

// Constructor for the Bonus Missile, which is a subclass of Missile
// and uses Missile's constructor
function BonusMissile( targets ) {
  var startX = rand( 0, CANVAS_WIDTH ),
  startY = -1,
        // Create some variation in the speed of missiles
        offSpeed = rand(300, 400) / 100,
        // Randomly pick a target for this missile
        target = targets[ rand(0, targets.length - 1) ],
        framesToTarget;

        Missile.call( this, { startX: startX,  startY: startY,
          endX: target[0], endY: target[1],
          color: 'blue', trailColor: '#00ffff', explodeColor: 'rgba(118,238,144,0.4)' } );

        framesToTarget = ( 650 - 30 * level ) / offSpeed;
        if( framesToTarget < 20 ) {
          framesToTarget = 20;
        }
        this.dx = ( this.endX - this.startX ) / framesToTarget;
        this.dy = ( this.endY - this.startY ) / framesToTarget;
        this.bonuscatched = false;
        this.target = target;
    // Make missiles heading to their target at random times
    this.delay = 20 + rand( 0, 50 + level * 20 );
    this.groundExplosion = false;
  }

// Make BonusMissile inherit from Missile
BonusMissile.prototype = Object.create( Missile.prototype );
BonusMissile.prototype.constructor = BonusMissile;

// Update the location and/or state of an enemy missile.
// The missile doesn't begin it's flight until its delay is past.
BonusMissile.prototype.update = function() {
  if( this.delay ) {
    this.delay--;
    return;
  }
  if( this.state === MISSILE.active && this.y >= this.endY ) {
      // Missile has hit a ground target (City or Anti Missile Battery)
      this.x = this.endX;
      this.y = this.endY;
      this.state = MISSILE.exploding;
      this.groundExplosion = true;
    }
    if( this.state === MISSILE.active ) {
      this.x += this.dx;
      this.y += this.dy;
    } else {
      this.explode();
    }
  };

  BonusMissile.prototype.bonus = function () {
    if (!this.bonuscatched) {
      this.bonuscatched = true;
        // bonus in ricarica di missili difensivi
        addMissile(3);
      }
    }

 /*   var addMissile = function (n) {
      $.each( antiMissileBatteries, function( index, amb ) {
        amb.missilesLeft += n;
        if (amb.missilesLeft > 6) {
          amb.missilesLeft = 6;
        }
      });
    } */

// When a missile that did not hit the ground is exploding, check if
// any enemy missile is in the explosion radius; if so, cause that
// enemy missile to begin exploding too.
// The bonus missiles will never explode because of a near explosion.
var explodeOtherMissiles = function( missile, ctx ) {
  if( !missile.groundExplosion ){
    $.each( enemyMissiles, function( index, otherMissile ) {
      if( ctx.isPointInPath( otherMissile.x, otherMissile.y ) && otherMissile.state === MISSILE.active) {
        if (level !== 9 || !(otherMissile instanceof BonusMissile)) {
          levelscore += 25 * getMultiplier();
          otherMissile.state = MISSILE.exploding;
        }
      }
    });
  }
};

// Get targets that may be attacked in a game Level. All targets
// selected here may not be attacked, but no target other than those
// selected here will be attacked in a game level.
var viableTargets = function() {
  var targets = [];

    // Include all active cities
    $.each( cities, function( index, city ) {
      if( city.active ) {
        targets.push( [city.x + 15, city.y - 10, city] );
      }
    });

    // Include all anti missile batteries
    $.each( antiMissileBatteries, function( index, amb ) {
      targets.push( [amb.x, amb.y, amb]);
    });

    return targets;
  };

// Operations to be performed on each game frame leading to the
// game animation
var nextFrame = function() {
  if (isDefined(contrAerea)) {
    contrAerea.shoot();
  }
  drawGameState();
  updateEnemyMissiles();
  drawEnemyMissiles();
  updatePlayerMissiles();
  drawPlayerMissiles();
  checkEndLevel();
};

// Check for the end of a Level, and then if the game is also ended
var checkEndLevel = function() {
  if( !enemyMissiles.length ) {
        // Stop animation
        stopLevel();
        $( '.container' ).off( 'click' );
        var missilesLeft = totalMissilesLeft(),
        citiesSaved  = totalCitiesSaved();

        // !citiesSaved ? endGame( missilesLeft ) : endLevel( missilesLeft, citiesSaved );
        endLevel( missilesLeft, citiesSaved );
      }
    };

// Handle the end of a level
var endLevel = function( missilesLeft, citiesSaved ) {
  var missilesBonus = citiesSaved === 6 ? missilesLeft * 5 * getMultiplier() : 0;
  var citiesBonus = citiesSaved === 6 ? citiesSaved * 100 * getMultiplier() : 0;
  var nextLevel = citiesSaved === 6 ? true : false;

  if (!nextLevel) {
        //console.log("[Messaggio dal comandante] Riprova, non devi perdere nessuna torretta.");
      } else {
        //console.log("[Messaggio dal comandante] Ottimo lavoro, recluta.");
      }
      drawEndLevel( missilesLeft, missilesBonus,
        citiesSaved, citiesBonus );

    // Show the new game score after 2 seconds
    setTimeout( function() {
      levelscore += missilesBonus + citiesBonus;
      drawEndLevel( missilesLeft, missilesBonus,
        citiesSaved, citiesBonus );
    }, 2000);

    if (nextLevel) {
        //newmsg("general", ["You did a good job, Recruit.","The war, however, is still going and the enemy could attack again at any moment."], {
         ({
          'speed': 30,
          'callback': function() {
                // settare il tempo in modo da far comparire tutta il testo prima della chiamata alla funzione
                setTimeout( setupNextLevel, 2000, nextLevel );
              }
            });

        // controllo i badge
        switch (level) {
          case 3:
          unlockBadge("Debug", "Finish Debug levels");
          break;
          case 6:
          unlockBadge("Refactoring", "Finish Refactoring levels");
          break;
          case 9:
          unlockBadge("Design", "Finish Design levels");
          break;
          case 10:
          unlockBadge("Level-10", "Win level 10");
          break;
          default:
        }

        if (missilesLeft >= 25) {
          unlockBadge("Win-25-missiles", "Win and keep 25 missiles");
        }
      } else {
        // livello non superato
        setTimeout( setupNextLevel, 2000, nextLevel );
        newmsg("general", ["We can't afford to lose ANY facility.", "Try again, Recruit, this time with more committment!"], {});
      }

    // badge destroy all bonus missiles, non dipende dal superamente del livello
    //if (bonusMissileDestroyed === gamelevel.missilesBonus ) {
     //   unlockBadge("Destroy-bonus-missiles", "Destroyed all bonus missiles.");
    //}
  };

// Move to the next level
var setupNextLevel = function(next) {
  if (next) {
        // aggiorno il punteggio totale dell'utente
        scoreArray[level-1] = levelscore;
        score = 0;
        $.each(scoreArray, function (index, el) {
          score += el;
        });

        // aumento il livello
        level++;

        // salvo i dati nella sessione e nel db
        if (level > maxLevel) {
          maxLevel = level;
        }
        $.post('/saveUserState', {
          level: maxLevel,
          score: score,
          levelScore: scoreArray.toString()
        });

        // carico la chat
        loadChat();

        // carico il codice del livello successivo
        editor.loadCode(level);
      }

    // inizializzo il gioco per il livello corrente
    missileCommand(next);
  };

    // Get missiles left in all anti missile batteries at the end of a level
    var totalMissilesLeft = function() {
      var total = 0;
      $.each( antiMissileBatteries, function(index, amb) {
        total += amb.missilesLeft;
      });
      return total;
    };

// Get count of undestroyed cities
var totalCitiesSaved = function() {
  var total = 0;
  $.each( cities, function(index, city) {
    if( city.active ) {
      total++;
    }
  });
  return total;
};

// Update all enemy missiles and remove those that have exploded
var updateEnemyMissiles = function() {
  $.each( enemyMissiles, function( index, missile ) {
    missile.update();
  });
  enemyMissiles = enemyMissiles.filter( function( missile ) {
    return missile.state !== MISSILE.exploded;
  });
};

// Draw all enemy missiles
var drawEnemyMissiles = function() {
  $.each( enemyMissiles, function( index, missile ) {
    missile.draw();
  });
};

// Update all player's missiles and remove those that have exploded
var updatePlayerMissiles = function() {
  $.each( playerMissiles, function( index, missile ) {
    missile.update();
  });
  playerMissiles = playerMissiles.filter( function( missile ) {
    return missile.state !== MISSILE.exploded;
  });
};

// Draw all player's missiles
var drawPlayerMissiles = function() {
  $.each( playerMissiles, function( index, missile ) {
    missile.draw();
  });
};

// Stop animating a game level
var stopLevel = function() {
  clearInterval( timerID );
};

// Start animating a game level
var startLevel = function() {

  var fps = 30;
  timerID = setInterval( nextFrame, 1000 / fps );

};

// Determine which Anti Missile Battery will be used to serve a
// player's request to shoot a missile. Determining factors are
// where the missile will be fired to and which anti missile
// batteries have missile(s) to serve the request

var firedToOuterThird = function( priority1, priority2, priority3) {
  if( antiMissileBatteries[priority1].hasMissile() ) {
    return priority1;
  } else if ( antiMissileBatteries[priority2].hasMissile() ) {
    return priority2;
  } else {
    return priority3;
  }
};

var firedtoMiddleThird = function( priority1, priority2 ) {
  if( antiMissileBatteries[priority1].hasMissile() ) {
    return priority1;
  } else {
    return priority2;
  }
};

var whichAntiMissileBattery = function( x ) {

  if( !antiMissileBatteries[0].hasMissile() &&
    !antiMissileBatteries[1].hasMissile() &&
    !antiMissileBatteries[2].hasMissile() ) {
    return -1;
}
if( x <= CANVAS_WIDTH / 3 ){
  return firedToOuterThird( 0, 1, 2 );
} else if( x <= (2 * CANVAS_WIDTH / 3) ) {
  if ( antiMissileBatteries[1].hasMissile() ) {
    return 1;
  } else {
    return ( x <= CANVAS_WIDTH / 2 ) ? firedtoMiddleThird( 0, 2 )
    : firedtoMiddleThird( 2, 0 );
  }
} else {
  return firedToOuterThird( 2, 1, 0 );
}
};

// Attach event Listeners to handle the player's input
var setupListeners = function() {
  $( '#mc-container' ).unbind();
  $( '#miscom' ).unbind();
  $( '#mc-container' ).one( 'click', function() {
    startLevel();

    $( '#miscom' ).unbind().click(function( event ) {
      var mousePos = getMousePos(this, event);
      playerShoot( mousePos.x + 25, mousePos.y);
      playerShoot( mousePos.x, mousePos.y);
      playerShoot( mousePos.x - 25, mousePos.y);
      
    });
  });
};

function getMousePos(canvas, evt){
  var rect = canvas.getBoundingClientRect();
  return{
    x: evt.clientX - rect.left,
    y: evt.clientY - rect.top
  }
};

function isDefined (x) {
  var undef;
  return x !== undef;
};

function userSolutionChecker(){
    //check the missile speed
    if (SPEEDMISSILEDEFENSE > 8 && SPEEDMISSILEDEFENSE < 15){
      return true;
    }
    else{
      return false;
    }
  }