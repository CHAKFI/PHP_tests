<style>
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
</style>
