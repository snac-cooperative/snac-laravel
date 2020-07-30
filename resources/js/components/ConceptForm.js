import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class ConceptForm extends Component {
  constructor(props) {
    super(props);
    this.state = {
      id: null,
      terms: []
    }
  }

  render() {
    return (
      <div>
        <p>Create a preferred term for this new concept.</p>
        <form id="term-form" method="post" action="/concepts">
          @csrf
          <div className="term form-group required">
            <div className="form-group">
              <label className="control-label col-xs-2" htmlFor="">Term</label>
              <div className="col-xs-6">
                <input type="text" id="term-input" className="form-control" name="term-value" data-term-id="" required=""/>
              </div>
            </div>
            <br />
          </div>
          <button type="submit" className="btn btn-primary" >Save Term</button>
        </form>
      </div>
    );
  }
}

export default ConceptForm;

if (document.getElementById('conceptForm')) {
  ReactDOM.render(<ConceptForm />, document.getElementById('conceptForm'));
}
