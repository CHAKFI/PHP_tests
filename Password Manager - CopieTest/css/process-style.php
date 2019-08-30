<style>
.button {
  border-radius: 20px;
  background-color: rgb(10, 0, 60);
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 18px;
  padding: 8px;
  width: 150px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 1px;
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

.butt {
  border-radius: 20px;
  background-color: rgb(10, 0, 70);
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 13px;
  padding: 6px;
  width: 98px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 1px;
 
}

.butt span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.butt span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.butt:hover span {
  padding-right: 25px;
}

.butt:hover span:after {
  opacity: 1;
  right: 0;
}


#brr {
  font-family: Century Gothic;
   font-size: 24px;
    background: rgba(10, 0, 60, 0.2);
     margin-top: -23px;
      height: 37px;
}

#mssgIndexWelcm {
  margin-top: -1px;
  font-family: Century Gothic;
}

#usr{
  color: green;
}

#usn, #ln, #pw {
  height: 100%;
   width: 98%;
    font-family: Century Gothic ;
     font-size: 14px;
}




</style>
  