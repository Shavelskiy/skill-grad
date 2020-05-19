import React from 'react';
import Breadcrumbs from '../../components/breadcrumbs/breacrumbs';
import Table from '../../components/table/table';
import Paginator from '../../components/paginator/paginator';
import Search from '../../components/search/search';
import PanelTitle from '../../components/panel/panel-title';

class LocationsIndex extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      tableHeader: ['Id', 'Название', 'Тип', 'Сортировка'],
      bodyKeys: ['id', 'name', 'type', 'sort'],
      body: [
        {
          id: 1,
          name: 'Россия',
          type: 'Страна',
          sort: 1,
        },
        {
          id: 2,
          name: 'Россия',
          type: 'Страна',
          sort: 1,
        },
        {
          id: 3,
          name: 'Россия',
          type: 'Страна',
          sort: 1,
        },
        {
          id: 4,
          name: 'Россия',
          type: 'Страна',
          sort: 1,
        },
      ],
      totalPages: 10,
      currentPage: 2,
    }
  }

  changePage(page) {
    this.setState({
      currentPage: page,
    })
  }

  render() {
    return (
      <div className="page">
        <Breadcrumbs/>

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
              header={this.state.tableHeader}
              body={this.state.body}
              bodyKeys={this.state.bodyKeys}
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
