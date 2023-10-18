#include "website_list_window.hpp"

#include <QHBoxLayout>
#include <QHeaderView>
#include <QVBoxLayout>

WebsiteListWindow::WebsiteListWindow(QWidget* parent) : QMainWindow(parent) {
    setWindowTitle("Изменение просматриваемых веб-сайтов");

    table_ = new QTableView(this);
    QObject::connect(
        table_,
        &QTableView::doubleClicked,
        this,
        &WebsiteListWindow::openEditForm
    );

    model_ = new WebsiteListModel(this);
    viewer_ = new WebsiteViewer(this);

    form_ = new WebsiteForm(this);
    form_->resize(500, 0);
    QObject::connect(
        form_, &WebsiteForm::submit, this, &WebsiteListWindow::onFormSubmit
    );

    QList<WebsiteDisplayInfo> values;
    values.append(WebsiteDisplayInfo{QUrl("https://google.ru"), 5000});
    values.append(WebsiteDisplayInfo{QUrl("https://ya.ru"), 5000});
    QList<QString> column_names = {"URL", "Время демонстрации"};
    model_->setValues(values);
    model_->setColumnNames(column_names);

    table_->setModel(model_);
    table_->horizontalHeader()->setSectionResizeMode(QHeaderView::Stretch);
    table_->setSelectionBehavior(QTableView::SelectRows);
    table_->setSelectionMode(QTableView::SingleSelection);

    create_button_ = new QPushButton(this);
    create_button_->setText("Добавить");
    create_button_->setFixedHeight(40);
    QObject::connect(
        create_button_,
        &QPushButton::clicked,
        this,
        &WebsiteListWindow::onCreateButtonClicked
    );

    edit_button_ = new QPushButton(this);
    edit_button_->setText("Изменить");
    edit_button_->setFixedHeight(40);
    QObject::connect(
        edit_button_,
        &QPushButton::clicked,
        this,
        &WebsiteListWindow::onEditButtonClicked
    );

    delete_button_ = new QPushButton(this);
    delete_button_->setText("Удалить");
    delete_button_->setFixedHeight(40);
    QObject::connect(
        delete_button_,
        &QPushButton::clicked,
        this,
        &WebsiteListWindow::onDeleteButtonClicked
    );

    view_button_ = new QPushButton(this);
    view_button_->setText("Просмотр");
    view_button_->setFixedHeight(50);
    QObject::connect(
        view_button_,
        &QPushButton::clicked,
        this,
        &WebsiteListWindow::onViewButtonClicked
    );

    QHBoxLayout* button_layout = new QHBoxLayout();

    button_layout->addWidget(create_button_);
    button_layout->addWidget(edit_button_);
    button_layout->addWidget(delete_button_);

    QVBoxLayout* layout = new QVBoxLayout();

    layout->addWidget(table_);
    layout->addLayout(button_layout);
    layout->addWidget(view_button_);

    QWidget* widget = new QWidget(this);
    widget->setLayout(layout);
    setCentralWidget(widget);
}

void WebsiteListWindow::onCreateButtonClicked(bool) {
    form_->clear();
    form_->setWindowTitle("Добавление URL");
    form_->show();
}

void WebsiteListWindow::onFormSubmit(WebsiteDisplayInfo value) {
    int row = form_->getRow();
    if (row == -1) {
        model_->addRow(std::move(value));
    } else {
        model_->setRow(row, std::move(value));
    }
}

void WebsiteListWindow::onEditButtonClicked(bool) {
    QModelIndexList select = table_->selectionModel()->selectedRows();
    if (select.empty()) {
        return;
    }
    openEditForm(select.front());
}

void WebsiteListWindow::onDeleteButtonClicked(bool) {
    QModelIndexList select = table_->selectionModel()->selectedRows();
    if (select.empty()) {
        return;
    }

    QModelIndex index = select.front();
    model_->removeRow(index.row());
}

void WebsiteListWindow::onViewButtonClicked(bool) {
    viewer_->resize(size());
    viewer_->setWebsiteInfo(model_->values());
    viewer_->show();
}

void WebsiteListWindow::openEditForm(QModelIndex index) {
    int row = index.row();
    form_->clear();
    form_->setFields(model_->getRow(row));
    form_->setRow(row);
    form_->setWindowTitle("Изменение URL");
    form_->show();
}
