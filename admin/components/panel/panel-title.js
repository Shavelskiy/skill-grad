import React from 'react';
import css from './panel-title.scss';

class PanelTitle extends React.Component {
  constructor(props) {
    super(props);

  }

  render() {
    let buttonTemplate = '';
    if (this.props.withButton === true) {
      buttonTemplate = (
        <div className="button-wrap">
          <a
            className="btn btn-primary"
            href={this.props.buttonLink}
          >
            {this.props.buttonText}
          </a>
        </div>
      );
    }

    return (
      <div className="panel-title">
        <h3>
          <i className={this.props.icon}></i>
          &nbsp;{this.props.title}
        </h3>
        {buttonTemplate}
      </div>
    );
  }
}

export default PanelTitle;
