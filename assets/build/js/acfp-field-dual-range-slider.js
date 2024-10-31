document.addEventListener('DOMContentLoaded', acfpDocumentReadyDualRangeSlider, false);

function acfpDocumentReadyDualRangeSlider () {
  const acfp_dual_range_slider_containers = document.getElementsByClassName("acfp_dual_range_slider_container");
  for(i=0; i<acfp_dual_range_slider_containers.length;i++){
    children=acfp_dual_range_slider_containers[i].children;
    j=0;
    for (const child of children) {
      j++;
      if(j==1){//sliders_control
        sliderInputs= child.children;
        fromSlider=sliderInputs[0];
        toSlider=sliderInputs[1];
      }else if(j==2){//number_control
         number_control_containers= child.children;
        container_1=number_control_containers[0];
        container_2=number_control_containers[1];
        container_3=number_control_containers[2];
        fromInput=container_1.children[1];
        toInput=container_2.children[1]
        valueTextInput=container_3.children[0]
      }
    }
    acfpInitDualRangeSlider(fromSlider, fromInput, toInput, toSlider, valueTextInput);
  }
}

function acfpInitDualRangeSlider(fromSlider, fromInput, toInput, toSlider, valueTextInput){
  acfpDualRangeSlider =new AcfpDualRangeSlider(fromSlider, fromInput, toInput, toSlider, valueTextInput);
}

class AcfpDualRangeSlider {
  fromSlider=null;
  toSlider=null;
  
  constructor(fromSlider, fromInput, toInput, toSlider, valueTextInput) {
    this.fromSlider=fromSlider;
    this.fromInput=fromInput;
    this.toInput=toInput;
    this.toSlider=toSlider;
    this.valueTextInput=valueTextInput;
    //event listeners
    this.toSliderInputListener = this.controlToSlider.bind(this);
    this.fromSliderInputListener = this.controlFromSlider.bind(this);
    this.init();
  }

  init(){
    this.fillSlider(this.getFromSlider(), this.getToSlider(), '#C6C6C6', '#25daa5', this.getToSlider(), true);
    this.getToSlider().addEventListener('input', this.toSliderInputListener);
    this.getFromSlider().addEventListener('input', this.fromSliderInputListener);
    this.getFromInput().oninput = () => this.controlFromInput(this.getFromSlider(), this.getFromInput(), this.getToInput());
    this.getToInput().oninput = () => this.controlToInput(this.getToSlider(), this.getFromInput(), this.getToInput());
  }
  
  controlFromInput(fromSlider, fromInput, toInput) {
    const [from, to] = this.getParsed(fromInput, toInput);
    if (from > to) {
        fromSlider.value = to;
        fromInput.value = to;
    } else {
        fromSlider.value = from;
    }
    //dispatch input event
    const inputEvent = new Event('input');
    fromSlider.dispatchEvent(inputEvent);
}
    
controlToInput(toSlider, fromInput, toInput) {
    const [from, to] = this.getParsed(fromInput, toInput);
    if (from <= to) {
        toSlider.value = to;
        toInput.value = to;
    } else {
        toInput.value = from;
    }
    //dispatch input event
    const inputEvent = new Event('input');
    toSlider.dispatchEvent(inputEvent);
}

controlFromSlider(){
  let from=parseFloat(this.getFromSlider().value);
  let to=parseFloat(this.getToSlider().value);
  if (from > to){
    let tmp=this.getToSlider();
    this.setToSlider(this.getFromSlider());
    this.setFromSlider(tmp);
  }
  this.updateNumberInputs();
  this.fillSlider(this.getFromSlider(), this.getToSlider(), '#C6C6C6', '#25daa5', this.getToSlider());
  this.controlValueInput(valueTextInput,fromSlider, toSlider);
}

controlToSlider(){
  let from=parseFloat(this.getFromSlider().value);
  let to=parseFloat(this.getToSlider().value);
  if (from > to){
    let tmp=this.getToSlider();
    this.setToSlider(this.getFromSlider());
    this.setFromSlider(tmp);
  } 
  this.fillSlider(this.getFromSlider(), this.getToSlider(), '#C6C6C6', '#25daa5', this.getToSlider());
  this.controlValueInput(valueTextInput,fromSlider, toSlider);
  this.updateNumberInputs();
}

updateNumberInputs(){
  this.getFromInput().value=this.getFromSlider().value;
  this.getToInput().value=this.getToSlider().value;
}


controlValueInput(){
  this.getValueTextInput().value =this.getFromSlider().value+","+this.getToSlider().value;
}

getParsed(currentFrom, currentTo) {
  const from = parseFloat(currentFrom.value, 10);
  const to = parseFloat(currentTo.value, 10);
  return [from, to];
}

fillSlider(from, to, sliderColor, rangeColor, controlSlider,initial) {
  if(parseFloat(initial!=true && controlSlider.offsetHeight)==0){
    controlSlider=this.getFromSlider();
  }
  const rangeDistance = to.max-to.min;
    const fromPosition = from.value - to.min;
    const toPosition = to.value - to.min;
    controlSlider.style.background = `linear-gradient(
      to right,
      ${sliderColor} 0%,
      ${sliderColor} ${(fromPosition)/(rangeDistance)*100}%,
      ${rangeColor} ${((fromPosition)/(rangeDistance))*100}%,
      ${rangeColor} ${(toPosition)/(rangeDistance)*100}%, 
      ${sliderColor} ${(toPosition)/(rangeDistance)*100}%, 
      ${sliderColor} 100%)`;
}

setToggleAccessible(currentTarget,toSlider) {
  if (Number(currentTarget.value) <= 0 ) {
    toSlider.style.zIndex = 2;
  } else {
    toSlider.style.zIndex = 0;
  }
}
  //Setters and getters
  setFromSlider(fromSlider) {
    this.fromSlider=fromSlider;
  }

  getFromSlider() {
    return this.fromSlider;
  }

  setToSlider(toSlider) {
    this.toSlider=toSlider;
  }

  getToSlider() {
    return this.toSlider;
  }

  setFromInput(fromInput) {
    this.fromInput=fromInput;
  }

  getFromInput() {
    return this.fromInput;
  }

  setToInput(toInput) {
    this.toInput=toInput;
  }

  getToInput() {
    return this.toInput;
  }

  setValueTextInput(valueTextInput) {
    this.valueTextInput=valueTextInput;
  }

  getValueTextInput() {
    return this.valueTextInput;
  }
}