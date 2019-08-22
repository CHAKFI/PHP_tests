<style>

<?php // for button in login-signup ?>

.button {
  border-radius: 50px;
  background-color: rgb(28, 27, 27);
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 18px;
  padding: 8px;
  width: 150px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 1px;
  margin-left: 115px; 
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}




<?php // for button in signup name= sign ?>
.butREG {
  border-radius: 50px;
  background-color: rgb(31, 178, 65);
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 18px;
  padding: 1px;
  width: 120px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 1px;
  margin-left: 1px; 
}

.butREG span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.butREG span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.butREG:hover span {
  padding-right: 25px;
}

.butREG:hover span:after {
  opacity: 1;
  right: 0;
}


<?php // for button in login name "signup" ?>
.butREG2 {
  border-radius: 50px;
  background-color: rgb(7, 24, 93);
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 18px;
  padding: 8px;
  width: 150px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 1px;
  margin-left: 7px; 
}

.butREG2 span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.butREG2 span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.butREG2:hover span {
  padding-right: 25px;
}

.butREG2:hover span:after {
  opacity: 1;
  right: 0;
}
</style>
