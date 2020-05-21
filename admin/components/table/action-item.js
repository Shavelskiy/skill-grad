import React from 'react';
import {Link} from 'react-router-dom';

class ActionItem extends React.Component {
  renderViewAction() {
    const link = this.props.action.link;
    return (
      <Link to={ `${link}/${this.props.item.id}` }>
        <i className="fa fa-eye"></i>
      </Link>
    )
  }

  render() {
    switch (this.props.action.type) {
      case 'view':
        return this.renderViewAction();
    }
  }
}

export default ActionItem;
