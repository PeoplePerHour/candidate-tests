export class Observable {
  constructor({id = ""}) {
    this.id = id;
    this.state = {};
    this.observers = [];
  }

  attach(observer) {
    if(observer instanceof Observer){
      this.observers.push(observer);
    }
  }

  dettach(observer) {
    //empty
  }

  notify() {
    this.observers.forEach((item,index)=>{item.update(this)});
  }

  getState() {
    return this.state;
  }

  setState(state = {}) {
    if(state instanceof Object){
      this.state = state;
      this.notify();
    }
  }
}

export class Observer {
  constructor(config = {}) {
    this.config = { hook: () => {} };
    if(config instanceof Object) Object.assign(this.config, config);
  }

  update({state}){

    this.config.hook(state);
  }
}

// Access Point
export let observers = [];
export let observables = [];

//Query Variables

export function getQueryVariable(variable) {
   let query = window.location.search.substring(1);
   let vars = query.split("&");
   for (let i=0;i<vars.length;i++) {
     let pair = vars[i].split("=");
     if(pair[0] === variable){return pair[1];}
   }
   return('');
}
