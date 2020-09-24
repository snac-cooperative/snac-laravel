import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { Table, Form, FormCheck, Col, Row, Button } from 'react-bootstrap';

class TermInput extends Component {
  constructor(props) {
    super(props);
    this.togglePreferred = this.togglePreferred.bind(this);
    this.state = {
      id: props.id,
      text: props.text,
      preferred: props.preferred,
    }
  }

  togglePreferred(e) {
    this.setState({
      preferred: !this.state.preferred
    })
  }

  render() {
    return (
      <tr>
        <td>{this.state.text}</td>
        <td><input onChange={this.togglePreferred} type="checkbox" checked={this.state.preferred} data-on="Preferred" data-off="Not preferred" data-toggle="toggle" data-target="#{`term_preferred_${this.state.id}`}" /></td>
      </tr>
    );
  }
}

class ConceptForm extends Component {
  constructor(props) {
    super(props);
    this.handleAddTerm = this.handleAddTerm.bind(this);
    this.inputText = this.inputText.bind(this);
    this.togglePreferred = this.togglePreferred.bind(this);
    this.getTerms = this.getTerms.bind(this);
    this.loadingSpinner = this.loadingSpinner.bind(this);
    this.state = {
      id: null,
      terms: [],
      text: '',
      preferred: true,
      loading: false
    }
  }

  handleAddTerm(e) {
    e.preventDefault();

    if (this.state.loading) { return; }

    const termValue = e.target.elements.termText.value.trim();
    const termIsPreferred = e.target.elements.preferredCheck.checked;

    this.setState({
      text: "",
      loading: true,
    });

    if (termValue) {
      //Verify we have an ID
      if(!this.state.id) {
        axios.post('concepts', {"term-value": termValue})
          .then(response => {
            const data = response.data;
            if (data["termId"]) {
              const term = {id: data["termId"], text: termValue, preferred: true};

              var initialPreferred = false || term.preferred ;

              this.setState((prevState) => {
                return {
                  id: data["id"],
                  text: "",
                  preferred: false,
                  loading: false,
                  terms: prevState.terms.concat([term])
                }
              });
            } else {
              console.log("There was an error creating the Concept");
            }
          }).catch( error => {
            console.log(error)
          });
      } else {
        axios.post(`concepts/${this.state.id}/add_term`, {"term-value": termValue})
          .then(response => {
            const data = response.data;
            if (data["termId"]) {
              const term = {id: data["termId"], text: termValue, preferred: termIsPreferred};
              var initialPreferred = false || term.preferred ;
              if (!initialPreferred && this.state.terms.length > 0) {
                initialPreferred = this.state.terms.reduce((acc, curr) => curr.preferred || acc);
              }

              this.setState((prevState) => {
                return {
                  text: "",
                  preferred: !initialPreferred,
                  loading: false,
                  terms: prevState.terms.concat([term])
                }
              });
            } else {
              console.log("There was an error creating the Concept");
            }
          }).catch( error => {
            console.log(error);
          });
      }
    }
  }

  inputText(e) {
    this.setState({text: e.target.value });
  }

  togglePreferred(e) {
    this.setState({ preferred: !e.target.checked })
  }

   getTerms() {
    if (this.state.terms.length > 0) {
      return <Table striped bordered hover>
        <thead>
          <tr>
            <th>Term</th>
            <th>Preferred</th>
          </tr>
        </thead>
        <tbody>
          {
            this.state.terms.map(
              (term) => <TermInput
                editHandler={this.editTerm}
                key={term.id}
                text={term.text}
                id={term.id}
                preferred={term.preferred}
              />
            )
          }
        </tbody>
        </Table>;
    }
    return "";
  }

  loadingSpinner() {
    if (this.state.loading) {
      return <i className="fa fa-spinner fa-spin" style={{padding: "0px 5px 0px 5px"}} />;
    }
  }

  render() {
    return (
      <div>
        <p>Create a preferred term for this new concept.</p>
        <div>
          {this.getTerms()}
        </div>
        <Form onSubmit={this.handleAddTerm}>
          @csrf
          <Form.Group as={Row} >
              <Col sm={1}>
              <Form.Label>
                Term
              </Form.Label>
              </Col>
              <Col sm={5}>
                <Form.Control
                  onChange={this.inputText}
                  required
                  type="text"
                  placeholder="Term"
                  id="termText"
                  value={this.state.text}
                />
              </Col>
              <Col sm={2}>
                <FormCheck
                  custom
                  type="switch"
                  onChange={this.togglePreferred}
                  checked={this.state.preferred}
                  label="Preferred"
                  id="preferredCheck"
                />
              </Col>
              <Col sm={3}>
                <Button
                  variant="primary"
                  type="submit"
                  disabled={!this.state.text || this.state.loading}
                >
                  {this.loadingSpinner()}Add Term
                </Button>
              </Col>
          </Form.Group>
          </Form>
        </div>
    );
  }
}

export default ConceptForm;

if (document.getElementById('conceptForm')) {
  ReactDOM.render(<ConceptForm />, document.getElementById('conceptForm'));
}
