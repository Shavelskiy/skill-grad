import React from 'react';
import Breadcrumbs from '../../components/breadcrumbs/breacrumbs';
import Table from '../../components/table/table';
import Paginator from '../../components/paginator/paginator';
import Search from '../../components/search/search';
import PanelTitle from '../../components/panel/panel-title';
import axios from 'axios';

const breadcrumbs = [
  {
    title: 'Главная',
    link: '/',
  },
  {
    title: 'Список местоположений',
    link: null,
  },
];

const table = [
  {
    title: 'Id',
    name: 'id',
  },
  {
    title: 'Название',
    name: 'name',
  },
  {
    title: 'Тип',
    name: 'type',
  },
  {
    title: 'Сортировка',
    name: 'sort',
  }
];

class LocationsIndex extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      body: [],
      paginatorRequest: null,
      disabledTable: false,
      totalPages: 0,
      currentPage: 1,
      order: {},
    }
  }

  componentDidMount() {
    this.loadItems();
  }

  loadItems() {
    const paginatorRequest = this.state.paginatorRequest;
    const axiosSource = axios.CancelToken.source();

    if (paginatorRequest) {
      paginatorRequest.cancel();
    }

    this.setState({
      paginatorRequest: {cancel: axiosSource.cancel},
      disabledTable: true,
    });

    const params = {
      page: this.state.currentPage,
      order: this.state.order,
    };

    axios.get('/api/admin/location', {
      cancelToken: axiosSource.token,
      params: params,
    })
      .then(response => {
        this.setState({
          body: response.data.items,
          totalPages: response.data.total_pages,
          currentPage: response.data.current_page,
          disabledTable: false,
        });
      });
  }

  changePage(page) {
    if (page === this.state.currentPage) {
      return;
    }

    this.setState({
      currentPage: page
    }, () => this.loadItems());
  }

  changeOrder(propName) {
    let order = this.state.order;

    if (!order[propName]) {
      order[propName] = null;
    }

    switch (order[propName]) {
      case null:
        order[propName] = 'asc';
        break;
      case 'asc':
        order[propName] = 'desc';
        break;
      case 'desc':
        delete order[propName];
        break;
    }

    this.setState({
      order: order
    }, () => this.loadItems());
  }

  render() {
    return (
      <div className="page">
        <Breadcrumbs items={breadcrumbs} />

        <div className="portlet">
          <PanelTitle
            title={'Список местоположений'}
            icon={'fa fa-globe'}
            withButton={true}
            buttonText={'Создать'}
            buttonLink={'/admin/rubric/create'}
          />

          <div className="body">
            {/*<Search/>*/}
            <Table
              table={table}
              body={this.state.body}
              order={this.state.order}
              disabled={this.state.disabledTable}
              changeOrder={(propName) => this.changeOrder(propName)}
            />
            <Paginator
              totalPages={this.state.totalPages}
              currentPage={this.state.currentPage}
              click={(page) => this.changePage(page)}
            />
          </div>
        </div>
      </div>
    );
  }
}

export default LocationsIndex;
