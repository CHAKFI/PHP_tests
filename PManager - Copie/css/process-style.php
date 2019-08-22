<style>
.button {
  border-radius: 50px;
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

#txt1 {
  font-family: Century Gothic;
   font-size: 30px;
    margin-left: 25%;
     color: white;
      width: 50%;
       background: rgba(1, 254, 18, 0.2);
        padding: 1px;
         border-radius: 15px;
}

#txt2 {
  font-family: Century Gothic;
   font-size: 30px;
    margin-left: 8%;
     color:white;
      width: 80%;
       background: rgba(254, 1, 1, 0.2);
        padding: 1px;
         border-radius: 15px;
}

#lien {
  font-family: Century Gothic;
  color: blue;
}
</style>
