import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class Hello extends Component {
  render() {
    return (
        <div>
          <h1>Hello World!</h1>
        </div>
    );
  }
}

export default Hello;

if (document.getElementById('hello')) {
  ReactDOM.render(<Hello />, document.getElementById('hello'));
}
