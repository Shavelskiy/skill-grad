import React from 'react';
import css from './paginator.scss';
import {Item, EmptyItem, Arrow} from './items';

class Paginator extends React.Component {
  renderItem(page) {
    return (
      <Item
        key={page}
        page={page}
        active={page === this.props.currentPage}
        click={() => this.props.click(page)}
      />
    );
  }

  getOffset() {
    let result = {
      start: 0,
      end: 0,
    };

    const currentPage = this.props.currentPage;
    const totalPages = this.props.totalPages;

    if (currentPage < 5 || currentPage > (totalPages - 4)) {
      if (currentPage == 3) {
        result.start = 4;
      } else if (currentPage == 4) {
        result.start = 5;
      } else {
        result.start = 3;
      }

      if (currentPage == (totalPages - 2)) {
        result.end = 3;
      } else if (currentPage == (totalPages - 3)) {
        result.end = 4;
      } else {
        result.end = 2;
      }
    } else {
      result.start = 2;
      result.end = 1;
    }

    return result;
  }

  render() {
    const currentPage = this.props.currentPage;
    const totalPages = this.props.totalPages;

    if (totalPages <= 1) {
      return '';
    }

    let items = [];

    if (currentPage !== 1) {
      items.push(
        <Arrow
          key={0}
          left={true}
          click={() => this.props.click(currentPage - 1)}
        />
      );
    }

    if (totalPages > 7) {
      const offset = this.getOffset();
      for (let i = 1; i <= offset.start; i++) {
        items.push(this.renderItem(i));
      }

      items.push(<EmptyItem key={0.5}/>);

      if (currentPage >= 5 && currentPage <= (totalPages - 4)) {
        for (let i = currentPage - 1; i <= currentPage + 1; i++) {
          items.push(this.renderItem(i));
        }

        items.push(<EmptyItem key={1.5}/>);
      }

      for (let i = totalPages - offset.end; i <= totalPages; i++) {
        items.push(this.renderItem(i));
      }
    } else {
      for (let i = 1; i <= totalPages; i++) {
        items.push(this.renderItem(i));
      }
    }

    if (currentPage < totalPages) {
      items.push(
        <Arrow
          key={totalPages + 1}
          left={false}
          click={() => this.props.click(currentPage + 1)}
        />
      );
    }

    return (
      <ul className="pagination">
        {items}
      </ul>
    );
  }
}

export default Paginator;
