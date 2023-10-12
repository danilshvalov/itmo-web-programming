#include "website_form.hpp"
#include "website_list_window.hpp"

#include <QApplication>
#include <QModelIndex>
#include <QTableWidget>
#include <QtWebEngineWidgets/QtWebEngineWidgets>

int main(int argc, char* argv[]) {
    QApplication app(argc, argv);

    WebsiteListWindow* website_window = new WebsiteListWindow();

    website_window->resize(800, 600);
    website_window->show();

    // QList<WebsiteDisplayInfo> values;
    // values.append(WebsiteDisplayInfo{QUrl("https://google.ru"), 5000});
    // values.append(WebsiteDisplayInfo{QUrl("https://ya.ru"), 5000});

    // QList<QString> column_names = {"URL", "Время демонстрации"};

    // WebsiteViewer* viewer = new WebsiteViewer();
    // viewer->resize(800, 600);
    // viewer->setWebsiteInfo(values);
    // viewer->show();

    // QTableView* table = new QTableView();

    // WebsiteListModel* model = new WebsiteListModel();
    // model->setValues(values);
    // model->setColumnNames(column_names);

    // table->setModel(model);
    // table->horizontalHeader()->setSectionResizeMode(QHeaderView::Stretch);
    // table->setSelectionBehavior(QTableView::SelectRows);
    // table->setSelectionMode(QTableView::SingleSelection);
    // table->show();

    // QWebEngineView* view = new QWebEngineView();
    // view->load(QUrl("https://ya.ru"));
    // view->show();

    return app.exec();
}
