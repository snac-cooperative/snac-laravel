import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class Term extends Component {
  constructor(props) {
    super(props);
    this.state = {
      id: null,
      text: null,
      preffered: false
    }
  }
  render() {
    return (
          <tr key={ this.props.id }><td>{ this.props.text }</td></tr>
    );
  }
}

export default Term;
