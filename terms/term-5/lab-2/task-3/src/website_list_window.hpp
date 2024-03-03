#pragma once

#include "website_display_info.hpp"
#include "website_form.hpp"
#include "website_list_model.hpp"
#include "website_viewer.hpp"

#include <QMainWindow>
#include <QPushButton>
#include <QTableView>

class WebsiteListWindow : public QMainWindow {
    Q_OBJECT

   public:
    WebsiteListWindow(QWidget* parent = nullptr);

   private:
    void onCreateButtonClicked(bool);

    void onFormSubmit(WebsiteDisplayInfo value);

    void onEditButtonClicked(bool);

    void onDeleteButtonClicked(bool);

    void onViewButtonClicked(bool);

    void openEditForm(QModelIndex index);

    QTableView* table_;
    WebsiteListModel* model_;
    WebsiteViewer* viewer_;
    WebsiteForm* form_;

    QPushButton* create_button_;
    QPushButton* edit_button_;
    QPushButton* delete_button_;
    QPushButton* view_button_;
};
