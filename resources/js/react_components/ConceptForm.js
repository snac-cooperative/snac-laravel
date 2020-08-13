import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class TermInput extends Component {
  constructor(props) {
    super(props);
    this.state = {
      id: props.id,
      text: props.text,
      preferred: props.preferred,
    }
  }

  render() {
    return (
      <div>
        {this.state.text}
        <button onClick={this.props.editHandler} />
      </div>
    );
  }
}

class ConceptForm extends Component {
  constructor(props) {
    super(props);
    this.handleAddTerm = this.handleAddTerm.bind(this);
    this.inputText = this.inputText.bind(this);
    this.state = {
      id: null,
      terms: [],
      text: ''
    }
  }

  handleAddTerm(e) {
    e.preventDefault();

    const termValue = e.target.elements.newTerm.value.trim();

    if (termValue) {
      //Verify we have an ID
      if(!this.state.id) {
        axios.post('/concepts', {"term-value": termValue})
          .then(response => {
            const data = response.data;
            if (data["termId"]) {
              const term = {id: data["termId"], text: termValue, preferred: true};
              console.log("Setting new state",term);
              this.setState((prevState) => {
                return {
                  id: data["id"],
                  terms: prevState.terms.concat([term])
                }
              })
            } else {
              console.log("There was an error creating the Concept");
            }
          }).catch( error => {
            console.log(error)
          });
      } else {
        axios.post(`/concepts/${this.state.id}/add_term`, {"term-value": termValue})
          .then(response => {
            const data = response.data;
            if (data["termId"]) {
              const term = {id: data["termId"], text: termValue, preferred: false};
              console.log("Setting new state",term);
              this.setState((prevState) => {
                return {
                  terms: prevState.terms.concat([term])
                }
              })
            } else {
              console.log("There was an error creating the Concept");
            }
          }).catch( error => {
            console.log(error)
          });
      }
      //build the Concept
      // Add the term to the concept
    }
  }

  inputText(e) {
    this.setState({text: e.target.value });
  }

  render() {
    return (
      <div>
        <p>Create a preferred term for this new concept.</p>
        <form onSubmit={this.handleAddTerm}>
          @csrf
          <div className="term form-group required">
            <div className="form-group">
              <label className="control-label col-xs-2" htmlFor="">Term</label>
              <div className="col-xs-6">
                {
                  this.state.terms.map((term) => <TermInput editHandler={this.editTerm} key={term.id} text={term.text} id={term.id} preferred={term.preferred} />)
                }
                  <input onChange={this.inputText} className="form-control" name="newTerm" value={this.state.text}/>
                </div>
              </div>
              <br />
            </div>
            <button type="submit" className="btn btn-primary" >Add Term</button>
          </form>
        </div>
    );
  }
}

export default ConceptForm;

if (document.getElementById('conceptForm')) {
  ReactDOM.render(<ConceptForm />, document.getElementById('conceptForm'));
}
