import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Term from './Term';

class Concept extends Component {

  constructor(props) {
    super(props);
    this.state = {
      id: null,
      terms: []
    }
  }

  render() {
    return (
    <table id="concept-table" className="table">
        <thead>
            <tr>
                <th>Concept</th>
            </tr>
        </thead>
        <tbody>
          {
            this.props.terms.map((term) => <Term key={term.id} text={term.text}/>)
          }
        </tbody>
    </table>
    );
  }
}

export default Concept;

if (document.getElementById('conceptShow')) {
  const propsContainer = document.getElementById('conceptShow');
  const props = JSON.parse(propsContainer.dataset["concept"]);
  ReactDOM.render(<Concept {... props} />, propsContainer);
}
