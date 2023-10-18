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

    return app.exec();
}
